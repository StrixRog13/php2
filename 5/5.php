$ symfony console make:user Admin

--- a/src/Entity/Admin.php
+++ b/src/Entity/Admin.php
@@ -75,6 +75,11 @@ class Admin implements UserInterface
         return $this;
     }

+    public function __toString(): string
+    {
+        return $this->username;
+    }
+
     /**
      * @see UserInterface
      */

      --- a/config/packages/security.yaml
+++ b/config/packages/security.yaml
@@ -1,7 +1,15 @@
 security:
+    encoders:
+        App\Entity\Admin:
+            algorithm: auto
+
     # https://symfony.com/doc/current/security.html#where-do-users-come-from-user-providers
     providers:
-        in_memory: { memory: null }
+        # used to reload user from session & other features (e.g. switch_user)
+        app_user_provider:
+            entity:
+                class: App\Entity\Admin
+                property: username
     firewalls:
         dev:
             pattern: ^/(_(profiler|wdt)|css|images|js)/

  $ symfony console make:migration
$ symfony console doctrine:migrations:migrate -n

Symfony Password Encoder Utility
================================

 Type in your password to be encoded:
 >

 ------------------ ---------------------------------------------------------------------------------------------------
  Key                Value
 ------------------ ---------------------------------------------------------------------------------------------------
  Encoder used       Symfony\Component\Security\Core\Encoder\MigratingPasswordEncoder
  Encoded password   $argon2id$v=19$m=65536,t=4,p=1$BQG+jovPcunctc30xG5PxQ$TiGbx451NKdo+g9vLtfkMy4KjASKSOcnNxjij4gTX1s
 ------------------ ---------------------------------------------------------------------------------------------------

 ! [NOTE] Self-salting encoder used: the encoder generated its own built-in salt.


 [OK] Password encoding succeeded

 $ symfony run psql -c "INSERT INTO admin (id, username, roles, password) \
  VALUES (nextval('admin_id_seq'), 'admin', '[\"ROLE_ADMIN\"]', \
  '\$argon2id\$v=19\$m=65536,t=4,p=1\$BQG+jovPcunctc30xG5PxQ\$TiGbx451NKdo+g9vLtfkMy4KjASKSOcnNxjij4gTX1s')"

  $ symfony console make:auth

--- a/config/packages/security.yaml
+++ b/config/packages/security.yaml
@@ -16,6 +16,13 @@ security:
             security: false
         main:
             anonymous: lazy
+            guard:
+                authenticators:
+                    - App\Security\AppAuthenticator
+            logout:
+                path: app_logout
+                # where to redirect after logout
+                # target: app_any_route

             # activate different ways to authenticate
             # https://symfony.com/doc/current/security.html#firewalls-authentication

 --- a/src/Security/AppAuthenticator.php
+++ b/src/Security/AppAuthenticator.php
@@ -95,8 +95,7 @@ class AppAuthenticator extends AbstractFormLoginAuthenticator implements Passwor
             return new RedirectResponse($targetPath);
         }

-        // For example : return new RedirectResponse($this->urlGenerator->generate('some_route'));
-        throw new \Exception('TODO: provide a valid redirect inside '.__FILE__);
+        return new RedirectResponse($this->urlGenerator->generate('admin'));
     }

     protected function getLoginUrl()


     --- a/config/packages/security.yaml
+++ b/config/packages/security.yaml
@@ -35,5 +35,5 @@ security:
     # Easy way to control access for large sections of your site
     # Note: Only the *first* access control that matches will be used
     access_control:
-        # - { path: ^/admin, roles: ROLE_ADMIN }
+        - { path: ^/admin, roles: ROLE_ADMIN }
         # - { path: ^/profile, roles: ROLE_USER }
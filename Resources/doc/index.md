Manhattan Public Bundle
============

Installation
------------

1. Add this bundle to your project in composer.json:

    Symfony 2.3 uses composer (http://www.getcomposer.org) to organize dependencies:

    ```json
    {
        "require": {
            "manhattan/public-bundle": "dev-master",
        }
    }
    ```

2. Add this bundle to your app/AppKernel.php:

    ``` php
    // application/ApplicationKernel.php
    public function registerBundles()
    {
        return array(
            // ...
            new Manhattan\PublicBundle\ManhattanPublicBundle(),
            // ...
        );
    }
    ```

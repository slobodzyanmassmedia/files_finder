Files finder
======================

Installation
============

Step 1: Download the Bundle
---------------------------

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```bash
$ composer require massmedia/files_finder_bundle 
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

Step 2: Enable the Bundle
-------------------------

Then, enable the bundle by adding it to the list of registered bundles
in the `app/AppKernel.php` file of your project:

    <?php
        // app/AppKernel.php
        
        // ...
        class AppKernel extends Kernel
        {
            public function registerBundles()
            {
                $bundles = array(
                    // ...
                    new JMS\SerializerBundle\JMSSerializerBundle(),
                    new FOS\RestBundle\FOSRestBundle(),
                    new Nelmio\ApiDocBundle\NelmioApiDocBundle(),
                    new Massmedia\FilesFinderBundle\FilesFinderBundle(),
                    new Bazinga\Bundle\RestExtraBundle\BazingaRestExtraBundle(),
                );
        
                // ...
            }
        
            // ...
        }
        
Step 2: Configure
-----------------

Routes file:

    # app/config/routing.yml
    NelmioApiDocBundle:
      resource: "@NelmioApiDocBundle/Resources/config/routing.yml"
      prefix:   /api/doc
      
Configure rest:

    # app/config/config.yml
    fos_rest:
        param_fetcher_listener: true
        body_listener: true
        view:
            view_response_listener: 'force'
        format_listener:
            rules:
                - { path: ^/api, priorities: [ json ], fallback_format: json, prefer_extension: true }
                - { path: '^/', priorities: [ 'html', '*/*'], fallback_format: ~, prefer_extension: true }

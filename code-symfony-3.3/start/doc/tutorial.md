# Update symfony 3.1 to 3.3 in composer.son

1. Update composer.json add 

``
"symfony/symfony": "3.3.0-RC1"
``

1.the symfony server is in a new bundle: WebServerBundle, update Appkernel Class and 
add 

``
$bundles[] = new Symfony\Bundle\WebServerBundle\WebServerBundle();
``

Update service.yml file to use autowiring

``
``

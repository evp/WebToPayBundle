#WebToPayBundle

##What is WebToPayBundle?
WebToPayBundle is a small bundle that can serve as a bridge between your Symfony framework and the original webtopay library.

We encourage you to first take a look at the [original library](https://bitbucket.org/webtopay/libwebtopay)


##Sections
* [Requirements](#requirements)
* [Installation](#installation)
* [Code samples](#code-samples)
* [Contacts](#contacts)

##Requirements
* Symfony 2.0+
* The original libwebtopay library (can be found [here](http://bitbucket.org/webtopay/libwebtopay/get/default.zip))

##Installation

###Symfony 2.1 installation (vendor)

* Execute these commands:

``` bash
    composer require webtopay/webtopay-bundle dev-master
```

* Enable the bundle in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        //... your existing bundles here
        new Evp\Bundle\WebToPayBundle\EvpWebToPayBundle(),
    );
}
```

* Configure your app/config/config.yml

``` yml
evp_web_to_pay:    
   credentials:    
       project_id: your_project_id    
       sign_password: your_password    
```

Don't forget to replace *your_project_id* and *your_password* with the actual credentials.    

That's it, you are now ready to use WebToPayBundle.

##Code samples
###CallbackValidation
Use the evp_web_to_pay.callback_validator service to perform callback validation

```php
   try {
     $callbackValidator = $this->get('evp_web_to_pay.callback_validator')->validateAndParseData($request->query->all());
     $data = $callbackValidator->validateAndParseData($request->query->all());
     if ($data['status'] == 1) {
       // Provide your customer with the service
     }

   } catch (\Exception $e) {
    //handle the callback validation error here
   }
```
###Creating a request
Use the evp_web_to_pay.request_builder service to create a request:

```php
$container->get('evp_web_to_pay.request_builder')->redirectPayment(array(
    'projectid' => 0,
    'sign_password' => 'd41d8cd98f00b204e9800998ecf8427e',
    'orderid' => 0,
    'amount' => 1000,
    'currency' => 'LTL',
    'country' => 'LT',
    'accepturl' => $self_url.'/accept.php',
    'cancelurl' => $self_url.'/cancel.php',
    'callbackurl' => $self_url.'/callback.php',
    'test' => 0,
));
```

Keep in mind the test parameter: you can set it to 1 to make test payments without actually paying.

##Contacts
If you have any further questions feel free to contact us:

"EVP International", UAB    
Mėnulio g. 7    
LT-04326 Vilnius    
El. paštas: pagalba@mokejimai.lt    
Tel. +370 (5) 2 03 27 19    
Faksas +370 (5) 2 63 91 79    

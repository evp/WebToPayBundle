#WebToPayBundle

##What is WebToPayBundle?
WebToPayBundle is a small bundle that can serve as a bridge between your Symfony framework and the original webtopay library.

We encourage you to first take a look at the [original library](https://bitbucket.org/paysera/libwebtopay)


##Sections
* [Requirements](#requirements)
* [Installation](#installation)
* [Code samples](#code-samples)
* [Using a sandbox](#using-a-sandbox)
* [Contacts](#contacts)

##Requirements
* Symfony 2.0+
* The original libwebtopay library (can be found [here](https://bitbucket.org/paysera/libwebtopay/get/default.zip))

##Installation

###Symfony 2.1 installation (vendor)

* Execute these commands:

``` bash
    composer require webtopay/libwebtopay 1.6.*@dev
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
###Controller example

Please see Symfony 2 controller example below with methods for every payment case and callback validation:

```php
namespace Vendor\Bundle\PaymentsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class PayseraPaymentsController extends Controller
{
    /**
     * @Route("/payments/paysera/pay", name="paysera.pay")
     */
    public function redirectToPaymentAction()
    {
        $acceptUrl = $this->generateUrl('paysera.accept');
        $cancelUrl = $this->generateUrl('paysera.cancel');
        $callbackUrl = $this->generateUrl('paysera.callback');

        $url = $this->container->get('evp_web_to_pay.request_builder')->buildRequestUrlFromData(array(
            'orderid' => 0,
            'amount' => 1000,
            'currency' => 'EUR',
            'country' => 'LT',
            'accepturl' => $acceptUrl,
            'cancelurl' => $cancelUrl,
            'callbackurl' => $callbackUrl,
            'test' => 0,
        ));

        return new RedirectResponse($url);
    }

    /**
     * @Route("/payments/paysera/accept", name="paysera.accept")
     */
    public function acceptAction()
    {
        // payment was successful
    }

    /**
     * @Route("/payments/paysera/cancel", name="paysera.cancel")
     */
    public function cancelAction()
    {
        // payment was unsuccessful
    }

    /**
     * @Route("/payments/paysera/callback", name="paysera.callback")
     */
    public function callbackAction()
    {
        try {
            $callbackValidator = $this->get('evp_web_to_pay.callback_validator');
            $data = $callbackValidator->validateAndParseData($this->getRequest()->query->all());
            if ($data['status'] == 1) {
                // Provide your customer with the service

                return new Response('OK');
            }
        } catch (\Exception $e) {
            //handle the callback validation error here

            return new Response($e->getTraceAsString(), 500);
        }
    }
}
```

Keep in mind the test parameter: you can set it to 1 to make test payments without actually paying.

##Using a sandbox
###Why use our sandbox?
Using the *test* parameter is a great way to see whether your *project_id* and *sign_password* settings are correct.
It will also allow you to test both the user return and the payment callback to your application once the payment has been accepted.

However, during the development phase of your application we suggest you use our [sandbox environment](https://sandbox.paysera.com)
With the sandbox environment you can go through the same steps that your clients will during a real payment, without actually using any of your real currency.

###Enable sandbox in your configuration
To enable the sandbox in your configuration add the following lines to your app/config/config.yml
``` yml
evp_web_to_pay:
   credentials:
       project_id: your_project_id
       sign_password: your_password
   use_sandbox: true
```
The *use_sandbox* parameter can be set to either *true* or *false*

##Contacts
If you have any further questions feel free to contact us:

"EVP International", UAB    
Mėnulio g. 7    
LT-04326 Vilnius    
El. paštas: pagalba@mokejimai.lt    
Tel. +370 (5) 2 03 27 19    
Faksas +370 (5) 2 63 91 79    

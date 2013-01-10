===========================================
Classes that SoapClient for easier work with Tipalti.
===========================================

Tipalti (www.tipalti.com) is global mass-payment service.
They have a SOAP API which is not the easiest to use.
Every method call needs to add key param. In my class it's done automatically.
The wsdl URIs are also set automatically.
I return result directly without going through functionNameResult object.
I use Laravel's Config here, you can change that for anything.
Unfortulatelly I could not extended standard SoapClient. Tipalti returned errorMessage 'PayerUnknown' then. I don't know why.

===========================================

It's as easy as that:

$soap = new Tipalti\PayerClient;
$result = $soap->GetDynamicKey();


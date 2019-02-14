<?php

/**
 * SAML 2.0 remote IdP metadata for SimpleSAMLphp.
 *
 * Remember to remove the IdPs you don't use from this file.
 *
 * See: https://simplesamlphp.org/docs/stable/simplesamlphp-reference-idp-remote
 */

/*INFOCERT*/

/*PROD*/

$metadata['https://identity.infocert.it'] = array (
  'entityid' => 'https://identity.infocert.it',
  'description' =>
  array (
    'it' => 'InfoCert S.p.A.',
    'en' => 'InfoCert S.p.A.',
    'fr' => 'InfoCert S.p.A.',
    'de' => 'InfoCert S.p.A.',
  ),
  'OrganizationName' =>
  array (
    'it' => 'InfoCert S.p.A.',
    'en' => 'InfoCert S.p.A.',
    'fr' => 'InfoCert S.p.A.',
    'de' => 'InfoCert S.p.A.',
  ),
  'name' =>
  array (
    'it' => 'InfoCert S.p.A.',
    'en' => 'InfoCert S.p.A.',
    'fr' => 'InfoCert S.p.A.',
    'de' => 'InfoCert S.p.A.',
  ),
  'OrganizationDisplayName' =>
  array (
    'it' => 'InfoCert S.p.A.',
    'en' => 'InfoCert S.p.A.',
    'fr' => 'InfoCert S.p.A.',
    'de' => 'InfoCert S.p.A.',
  ),
  'url' =>
  array (
    'it' => 'https://www.infocert.it',
    'en' => 'https://www.infocert.it/international/?lang=en',
    'fr' => 'https://www.infocert.it/international/?lang=fr',
    'de' => 'https://www.infocert.it/international/?lang=de',
  ),
  'OrganizationURL' =>
  array (
    'it' => 'https://www.infocert.it',
    'en' => 'https://www.infocert.it/international/?lang=en',
    'fr' => 'https://www.infocert.it/international/?lang=fr',
    'de' => 'https://www.infocert.it/international/?lang=de',
  ),
  'contacts' =>
  array (
  ),
  'metadata-set' => 'saml20-idp-remote',
  'sign.authnrequest' => true,
  'SingleSignOnService' =>
  array (
    0 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
      'Location' => 'https://identity.infocert.it/spid/samlsso',
    ),
    1 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
      'Location' => 'https://identity.infocert.it/spid/samlsso',
    ),
  ),
  'SingleLogoutService' =>
  array (
    0 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
      'Location' => 'https://identity.infocert.it/spid/samlslo',
      'ResponseLocation' => 'https://identity.infocert.it/spid/samlslo/response',
    ),
    1 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
      'Location' => 'https://identity.infocert.it/spid/samlslo',
      'ResponseLocation' => 'https://identity.infocert.it/spid/samlslo/response',
    ),
  ),
  'ArtifactResolutionService' =>
  array (
  ),
  'NameIDFormats' =>
  array (
    0 => 'urn:oasis:names:tc:SAML:2.0:nameid-format:transient',
  ),
  'keys' =>
  array (
    0 =>
    array (
      'encryption' => false,
      'signing' => true,
      'type' => 'X509Certificate',
      'X509Certificate' => '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',
    ),
  ),
);

/*FINE INFOCERT PROD*/



/*TIM*/

/*INIZIO TIM PROD*/

$metadata['https://login.id.tim.it/affwebservices/public/saml2sso'] = array (
  'entityid' => 'https://login.id.tim.it/affwebservices/public/saml2sso',
  'description' =>
  array (
    'en' => 'TI Trust Technologies srl',
  ),
  'OrganizationName' =>
  array (
    'en' => 'TI Trust Technologies srl',
  ),
  'name' =>
  array (
    'en' => 'Trust Technologies srl',
  ),
  'OrganizationDisplayName' =>
  array (
    'en' => 'Trust Technologies srl',
  ),
  'url' =>
  array (
    'en' => 'https://www.trusttechnologies.it',
  ),
  'OrganizationURL' =>
  array (
    'en' => 'https://www.trusttechnologies.it',
  ),
  'contacts' =>
  array (
  ),
  'metadata-set' => 'saml20-idp-remote',
  'sign.authnrequest' => true,
  'SingleSignOnService' =>
  array (
    0 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
      'Location' => 'https://login.id.tim.it/affwebservices/public/saml2sso',
    ),
    1 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
      'Location' => 'https://login.id.tim.it/affwebservices/public/saml2sso',
    ),
  ),
  'SingleLogoutService' =>
  array (
    0 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
      'Location' => 'https://login.id.tim.it/affwebservices/public/saml2slo',
    ),
    1 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
      'Location' => 'https://login.id.tim.it/affwebservices/public/saml2slo',
    ),
  ),
  'ArtifactResolutionService' =>
  array (
  ),
  'NameIDFormats' =>
  array (
    0 => 'urn:oasis:names:tc:SAML:2.0:nameid-format:transient',
  ),
  'keys' =>
  array (
    0 =>
    array (
      'encryption' => false,
      'signing' => true,
      'type' => 'X509Certificate',
      'X509Certificate' => 'MIIEKTCCAxGgAwIBAgIJAOCOuLmV0s27MA0GCSqGSIb3DQEBCwUAMIGqMSIwIAYDVQQDDBlUSSBUcnVzdCBUZWNobm9sb2dpZXMgc3JsMSgwJgYDVQQLDB9TZXJ2aXppIHBlciBsJ2lkZW50aXRhIGRpZ2l0YWxlMS4wLAYDVQQKDCVUZWxlY29tIEl0YWxpYSBUcnVzdCBUZWNobm9sb2dpZXMgc3JsMRAwDgYDVQQHDAdQb21lemlhMQswCQYDVQQIDAJSTTELMAkGA1UEBhMCSVQwHhcNMTcxMTE3MTUzNzIyWhcNMjExMTE2MTUzNzIyWjCBqjEiMCAGA1UEAwwZVEkgVHJ1c3QgVGVjaG5vbG9naWVzIHNybDEoMCYGA1UECwwfU2Vydml6aSBwZXIgbCdpZGVudGl0YSBkaWdpdGFsZTEuMCwGA1UECgwlVGVsZWNvbSBJdGFsaWEgVHJ1c3QgVGVjaG5vbG9naWVzIHNybDEQMA4GA1UEBwwHUG9tZXppYTELMAkGA1UECAwCUk0xCzAJBgNVBAYTAklUMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAwEBMMNhDczJh9ewCYX/Ag135q4c0n4Qg6FGfX7mZcg6TVI8IBKdeLHUC/e80iyVkufmqeu0udaFPWywyWJ4nhP10oi0ft1ftO+7XYzX4yDPoiRtsF6dtI3drjyaHVgWcDOWJIVGAJtLbdp5vcFLcboDlw4d2JC9if8wndMK9d4Kbb1P4+6v/ERaGozBFFntzuGRUAq5f5tsk9mh6D+g38xdHnK1tj1PcDIvw0DaRkD6/JL1rjHss+5sLSHCRtT7FG0ynQne1PjnEgUXL9M0xeeS7cV2hSxDU2ghZ7t8pzcEY8vJp/mWA7PHT07Nonp3yoh8dgqBvAa+sS6wqpiPBfQIDAQABo1AwTjAdBgNVHQ4EFgQURVRGXUUj2q6nPlqzvIKHtQx4VrAwHwYDVR0jBBgwFoAURVRGXUUj2q6nPlqzvIKHtQx4VrAwDAYDVR0TBAUwAwEB/zANBgkqhkiG9w0BAQsFAAOCAQEAOIndKJCOyi0qP0IK894er7/jGxV6XCEXY5PLlFa9ibnaPjusYXlMPn6rIjDUAkcMj/fVF0XYa862At1GWclS6S6yYDt06W/GoMknM5XsByxO5HzA7iuTc4MheUTdlvD05PtY6n3SXVQLTNp+zHdh/LlhI1d380DFDR8wZJzUnYJ+vb+2DU62+4gVytk0C6b4RNEK4kfHkQGdJyKnLjxtm66iJBP5w+cC1A0UdGx7xLv8EIVued0L9agJi5CCbly5UGXEGvGUZf7vSSMV0UM2tGbNY5vsZQX0aRl9NGZOsKBydY5FEgCk+SLYAHDq29EZZRcPE6dJqB1d5zLwUQ/vZg==',
    ),
  ),
);
/*FINE TIM PROD*/

// POSTE NUOVO

$metadata['https://posteid.poste.it'] = array (
  'entityid' => 'https://posteid.poste.it',
  'description' =>
  array (
    'it' => 'Poste Italiane SpA',
  ),
  'OrganizationName' =>
  array (
    'it' => 'Poste Italiane SpA',
  ),
  'name' =>
  array (
    'it' => 'Poste Italiane SpA',
  ),
  'OrganizationDisplayName' =>
  array (
    'it' => 'Poste Italiane SpA',
  ),
  'url' =>
  array (
    'it' => 'https://www.poste.it',
  ),
  'OrganizationURL' =>
  array (
    'it' => 'https://www.poste.it',
  ),
  'contacts' =>
  array (
  ),
  'metadata-set' => 'saml20-idp-remote',
  'sign.authnrequest' => true,
  'SingleSignOnService' =>
  array (
    0 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
      'Location' => 'https://posteid.poste.it/jod-fs/ssoservicepost',
    ),
    1 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
      'Location' => 'https://posteid.poste.it/jod-fs/ssoserviceredirect',
    ),
  ),
  'SingleLogoutService' =>
  array (
    0 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
      'Location' => 'https://posteid.poste.it/jod-fs/sloservicepost',
      'ResponseLocation' => 'https://posteid.poste.it/jod-fs/sloserviceresponsepost',
    ),
    1 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
      'Location' => 'https://posteid.poste.it/jod-fs/sloserviceredirect',
      'ResponseLocation' => 'https://posteid.poste.it/jod-fs/sloserviceresponseredirect',
    ),
  ),
  'ArtifactResolutionService' =>
  array (
  ),
  'NameIDFormats' =>
  array (
    0 => 'urn:oasis:names:tc:SAML:2.0:nameid-format:transient',
  ),
  'keys' =>
  array (
    0 =>
    array (
      'encryption' => false,
      'signing' => true,
      'type' => 'X509Certificate',
      'X509Certificate' => 'MIIEKzCCAxOgAwIBAgIDE2Y0MA0GCSqGSIb3DQEBCwUAMGAxCzAJBgNVBAYTAklUMRgwFgYDVQQK
DA9Qb3N0ZWNvbSBTLnAuQS4xIDAeBgNVBAsMF0NlcnRpZmljYXRpb24gQXV0aG9yaXR5MRUwEwYD
VQQDDAxQb3N0ZWNvbSBDQTMwHhcNMTYwMjI2MTU1MjQ0WhcNMjEwMjI2MTU1MjQ0WjBxMQswCQYD
VQQGEwJJVDEOMAwGA1UECAwFSXRhbHkxDTALBgNVBAcMBFJvbWUxHjAcBgNVBAoMFVBvc3RlIEl0
YWxpYW5lIFMucC5BLjENMAsGA1UECwwEU1BJRDEUMBIGA1UEAwwLSURQLVBvc3RlSUQwggEiMA0G
CSqGSIb3DQEBAQUAA4IBDwAwggEKAoIBAQDZFEtJoEHFAjpCaZcj5DVWrRDyaLZyu31XApslbo87
CyWz61OJMtw6QQU0MdCtrYbtSJ6vJwx7/6EUjsZ3u4x3EPLdlkyiGOqukPwATv4c7TVOUVs5onIq
TphM9b+AHRg4ehiMGesm/9d7RIaLuN79iPUvdLn6WP3idAfEw+rhJ/wYEQ0h1Xm5osNUgtWcBGav
ZIjLssWNrDDfJYxXH3QZ0kI6feEvLCJwgjXLGkBuhFehNhM4fhbX9iUCWwwkJ3JsP2++Rc/iTA0L
ZhiUsXNNq7gBcLAJ9UX2V1dWjTzBHevfHspzt4e0VgIIwbDRqsRtF8VUPSDYYbLoqwbLt18XAgMB
AAGjgdwwgdkwRgYDVR0gBD8wPTAwBgcrTAsBAgEBMCUwIwYIKwYBBQUHAgEWF2h0dHA6Ly93d3cu
cG9zdGVjZXJ0Lml0MAkGBytMCwEBCgIwDgYDVR0PAQH/BAQDAgSwMB8GA1UdIwQYMBaAFKc0XP2F
ByYU2l0gFzGKE8zVSzfmMD8GA1UdHwQ4MDYwNKAyoDCGLmh0dHA6Ly9wb3N0ZWNlcnQucG9zdGUu
aXQvcG9zdGVjb21jYTMvY3JsMy5jcmwwHQYDVR0OBBYEFEvrikZQkfBjuiTpxExSBe8wGgsyMA0G
CSqGSIb3DQEBCwUAA4IBAQBNAw8UoeiCF+1rFs27d3bEef6CLe/PJga9EfwKItjMDD9QzT/FShRW
KLHlK69MHL1ZLPRPvuWUTkIOHTpNqBPILvO1u13bSg+6o+2OdqAkCBkbTqbGjWSPLaTUVNV6MbXm
vttD8Vd9vIZg1xBBG3Fai13dwvSj3hAZd8ug8a8fW1y/iDbRC5D1O+HlHDuvIW4LbJ093jdj+oZw
Syd216gtXL00QA0C1uMuDv9Wf9IxniTb710dRSgIcM4/eR7832fZgdOsoalFzGYWxSCs8WOZrjpu
b1fdaRSEuCQk2+gmdsiRcTs9EqPCCNiNlrNAiWEyGtL8A4ao3pDMwCtrb2yr',
    ),
  ),
);


/*INIZIO SIELTE PROD*/

$metadata['https://identity.sieltecloud.it'] = array (
  'entityid' => 'https://identity.sieltecloud.it',
  'description' =>
  array (
    'en' => 'Sielte S.p.A.',
    'it' => 'Sielte S.p.A.',
  ),
  'OrganizationName' =>
  array (
    'en' => 'Sielte S.p.A.',
    'it' => 'Sielte S.p.A.',
  ),
  'name' =>
  array (
    'en' => 'http://www.sielte.it',
    'it' => 'http://www.sielte.it',
  ),
  'OrganizationDisplayName' =>
  array (
    'en' => 'http://www.sielte.it',
    'it' => 'http://www.sielte.it',
  ),
  'url' =>
  array (
    'en' => 'http://www.sielte.it',
    'it' => 'http://www.sielte.it',
  ),
  'OrganizationURL' =>
  array (
    'en' => 'http://www.sielte.it',
    'it' => 'http://www.sielte.it',
  ),
  'contacts' =>
  array (
  ),
  'metadata-set' => 'saml20-idp-remote',
  'sign.authnrequest' => true,
  'SingleSignOnService' =>
  array (
    0 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
      'Location' => 'https://identity.sieltecloud.it/simplesaml/saml2/idp/SSO.php',
    ),
    1 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
      'Location' => 'https://identity.sieltecloud.it/simplesaml/saml2/idp/SSO.php',
    ),
  ),
  'SingleLogoutService' =>
  array (
    0 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
      'Location' => 'https://identity.sieltecloud.it/simplesaml/saml2/idp/SLS.php',
    ),
    1 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
      'Location' => 'https://identity.sieltecloud.it/simplesaml/saml2/idp/SLS.php',
    ),
  ),
  'ArtifactResolutionService' =>
  array (
  ),
  'NameIDFormats' =>
  array (
    0 => 'urn:oasis:names:tc:SAML:2.0:nameid-format:transient',
  ),
  'keys' =>
  array (
    0 =>
    array (
      'encryption' => false,
      'signing' => true,
      'type' => 'X509Certificate',
      'X509Certificate' => 'MIIDczCCAlugAwIBAgIJAMsX0iEKQM6xMA0GCSqGSIb3DQEBCwUAMFAxCzAJBgNVBAYTAklUMQ4wDAYDVQQIDAVJdGFseTEgMB4GA1UEBwwXU2FuIEdyZWdvcmlvIGRpIENhdGFuaWExDzANBgNVBAoMBlNpZWx0ZTAeFw0xNTEyMTQwODE0MTVaFw0yNTEyMTMwODE0MTVaMFAxCzAJBgNVBAYTAklUMQ4wDAYDVQQIDAVJdGFseTEgMB4GA1UEBwwXU2FuIEdyZWdvcmlvIGRpIENhdGFuaWExDzANBgNVBAoMBlNpZWx0ZTCCASIwDQYJKoZIhvcNAQEBBQADggEPADCCAQoCggEBANIRlOjM/tS9V9jYjJreqZSctuYriLfPTDgX2XdhWEbMpMpwA9p0bsbLQoC1gP0piLO+qbCsIh9+boPfb4/dLIA7E+Vmm5/+evOtzvjfHG4oXjZK6jo08QwkVV8Bm1jkakJPVZ57QFbyDSr+uBbIMY7CjA2LdgnIIwKN/kSfFhrZUMJ6ZxwegM100X5psfNPSV9WUtgHsvqlIlvydPo2rMm21sg+2d3Vtg8DthNSYRLqgazCc0NTsigrH7niSbJCO0nq/svMX2rSFdh5GFK7/pxT+c3OFWqIR8r+RX4qW+auJqkbTuNRwxV22Sm6r69ZJwV0WspvsVJi+FYqiyoWhgUCAwEAAaNQME4wHQYDVR0OBBYEFCUx063GwUhEFDllwCBe/+jdeW+XMB8GA1UdIwQYMBaAFCUx063GwUhEFDllwCBe/+jdeW+XMAwGA1UdEwQFMAMBAf8wDQYJKoZIhvcNAQELBQADggEBADF94c3JwyBM86QBLeoUZxRYKPniba8B39FfJk0pb+LejKfZMvspOrOFgYQQ9UrS8IFkBX9Xr7/tjRbr2cPwZNjrEZhoq+NfcE09bnaWTyEl1IEKK8TWOupJj9UNVpYXX0LfIRrMwNEzAPQykOaqPOnyHxOCPTY957xXSo3jXOyvugtvPHbd+iliAzUoPm1tgiTKWS+EkQ/e22eFv5NEyT+oHiKovrQ+voPWOIvJVMjiTyxRic8fEnI9zzV0SxWvFvty77wgcYbeEuFZa3iidhojUge8o1uY/JUyQjFxcvvfAgWSIZwdHiNyWaAgwzLPmPCPsvBdR3xrlcDg/9Bd3D0=',
    ),
    1 =>
    array (
      'encryption' => true,
      'signing' => false,
      'type' => 'X509Certificate',
      'X509Certificate' => 'MIIDczCCAlugAwIBAgIJAMsX0iEKQM6xMA0GCSqGSIb3DQEBCwUAMFAxCzAJBgNVBAYTAklUMQ4wDAYDVQQIDAVJdGFseTEgMB4GA1UEBwwXU2FuIEdyZWdvcmlvIGRpIENhdGFuaWExDzANBgNVBAoMBlNpZWx0ZTAeFw0xNTEyMTQwODE0MTVaFw0yNTEyMTMwODE0MTVaMFAxCzAJBgNVBAYTAklUMQ4wDAYDVQQIDAVJdGFseTEgMB4GA1UEBwwXU2FuIEdyZWdvcmlvIGRpIENhdGFuaWExDzANBgNVBAoMBlNpZWx0ZTCCASIwDQYJKoZIhvcNAQEBBQADggEPADCCAQoCggEBANIRlOjM/tS9V9jYjJreqZSctuYriLfPTDgX2XdhWEbMpMpwA9p0bsbLQoC1gP0piLO+qbCsIh9+boPfb4/dLIA7E+Vmm5/+evOtzvjfHG4oXjZK6jo08QwkVV8Bm1jkakJPVZ57QFbyDSr+uBbIMY7CjA2LdgnIIwKN/kSfFhrZUMJ6ZxwegM100X5psfNPSV9WUtgHsvqlIlvydPo2rMm21sg+2d3Vtg8DthNSYRLqgazCc0NTsigrH7niSbJCO0nq/svMX2rSFdh5GFK7/pxT+c3OFWqIR8r+RX4qW+auJqkbTuNRwxV22Sm6r69ZJwV0WspvsVJi+FYqiyoWhgUCAwEAAaNQME4wHQYDVR0OBBYEFCUx063GwUhEFDllwCBe/+jdeW+XMB8GA1UdIwQYMBaAFCUx063GwUhEFDllwCBe/+jdeW+XMAwGA1UdEwQFMAMBAf8wDQYJKoZIhvcNAQELBQADggEBADF94c3JwyBM86QBLeoUZxRYKPniba8B39FfJk0pb+LejKfZMvspOrOFgYQQ9UrS8IFkBX9Xr7/tjRbr2cPwZNjrEZhoq+NfcE09bnaWTyEl1IEKK8TWOupJj9UNVpYXX0LfIRrMwNEzAPQykOaqPOnyHxOCPTY957xXSo3jXOyvugtvPHbd+iliAzUoPm1tgiTKWS+EkQ/e22eFv5NEyT+oHiKovrQ+voPWOIvJVMjiTyxRic8fEnI9zzV0SxWvFvty77wgcYbeEuFZa3iidhojUge8o1uY/JUyQjFxcvvfAgWSIZwdHiNyWaAgwzLPmPCPsvBdR3xrlcDg/9Bd3D0=',
    ),
  ),
);
/*FINE SIELTE PROD*/

/* INIZIO ARUBA PROD */

$metadata['https://loginspid.aruba.it'] = array (
  'entityid' => 'https://loginspid.aruba.it',
  'description' =>
  array (
    'it' => 'ArubaPEC S.p.A.',
  ),
  'OrganizationName' =>
  array (
    'it' => 'ArubaPEC S.p.A.',
  ),
  'name' =>
  array (
    'it' => 'ArubaPEC S.p.A.',
  ),
  'OrganizationDisplayName' =>
  array (
    'it' => 'ArubaPEC S.p.A.',
  ),
  'url' =>
  array (
    'it' => 'https://www.pec.it/',
  ),
  'OrganizationURL' =>
  array (
    'it' => 'https://www.pec.it/',
  ),
  'contacts' =>
  array (
  ),
  'metadata-set' => 'saml20-idp-remote',
  'sign.authnrequest' => true,
  'SingleSignOnService' =>
  array (
    0 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
      'Location' => 'https://loginspid.aruba.it/ServiceLoginWelcome',
    ),
    1 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
      'Location' => 'https://loginspid.aruba.it/ServiceLoginWelcome',
    ),
  ),
  'SingleLogoutService' =>
  array (
    0 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
      'Location' => 'https://loginspid.aruba.it/ServiceLogoutRequest',
    ),
    1 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
      'Location' => 'https://loginspid.aruba.it/ServiceLogoutRequest',
    ),
  ),
  'ArtifactResolutionService' =>
  array (
  ),
  'NameIDFormats' =>
  array (
    0 => 'urn:oasis:names:tc:SAML:2.0:nameid-format:transient',
  ),
  'keys' =>
  array (
    0 =>
    array (
      'encryption' => false,
      'signing' => true,
      'type' => 'X509Certificate',
      'X509Certificate' => 'MIIExTCCA62gAwIBAgIQIHtEvEhGM77HwqsuvSbi9zANBgkqhkiG9w0BAQsFADBsMQswCQYDVQQG
EwJJVDEYMBYGA1UECgwPQXJ1YmFQRUMgUy5wLkEuMSEwHwYDVQQLDBhDZXJ0aWZpY2F0aW9uIEF1
dGhvcml0eUIxIDAeBgNVBAMMF0FydWJhUEVDIFMucC5BLiBORyBDQSAyMB4XDTE3MDEyMzAwMDAw
MFoXDTIwMDEyMzIzNTk1OVowgaAxCzAJBgNVBAYTAklUMRYwFAYDVQQKDA1BcnViYSBQRUMgc3Bh
MREwDwYDVQQLDAhQcm9kb3R0bzEWMBQGA1UEAwwNcGVjLml0IHBlYy5pdDEZMBcGA1UEBRMQWFhY
WFhYMDBYMDBYMDAwWDEPMA0GA1UEKgwGcGVjLml0MQ8wDQYDVQQEDAZwZWMuaXQxETAPBgNVBC4T
CDE2MzQ1MzgzMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAqt2oHJhcp03l73p+QYpE
J+f3jYYj0W0gos0RItZx/w4vpsiKBygaqDNVWSwfo1aPdVDIX13f62O+lBki29KTt+QWv5K6SGHD
UXYPntRdEQlicIBh2Z0HfrM7fDl+xeJrMp1s4dsSQAuB5TJOlFZq7xCQuukytGWBTvjfcN/os5aE
sEg+RbtZHJR26SbbUcIqWb27Swgj/9jwK+tvzLnP4w8FNvEOrNfR0XwTMNDFrwbOCuWgthv5jNBs
VZaoqNwiA/MxYt+gTOMj/o5PWKk8Wpm6o/7/+lWAoxh0v8x9OkbIi+YaFpIxuCcUqsrJJk63x2gH
Cc2nr+yclYUhsKD/AwIDAQABo4IBLDCCASgwDgYDVR0PAQH/BAQDAgeAMB0GA1UdDgQWBBTKQ3+N
PGcXFk8nX994vMTVpba1EzBHBgNVHSAEQDA+MDwGCysGAQQBgegtAQEBMC0wKwYIKwYBBQUHAgEW
H2h0dHBzOi8vY2EuYXJ1YmFwZWMuaXQvY3BzLmh0bWwwWAYDVR0fBFEwTzBNoEugSYZHaHR0cDov
L2NybC5hcnViYXBlYy5pdC9BcnViYVBFQ1NwQUNlcnRpZmljYXRpb25BdXRob3JpdHlCL0xhdGVz
dENSTC5jcmwwHwYDVR0jBBgwFoAU8v9jQBwRQv3M3/FZ9m7omYcxR3kwMwYIKwYBBQUHAQEEJzAl
MCMGCCsGAQUFBzABhhdodHRwOi8vb2NzcC5hcnViYXBlYy5pdDANBgkqhkiG9w0BAQsFAAOCAQEA
nEw0NuaspbpDjA5wggwFtfQydU6b3Bw2/KXPRKS2JoqGmx0SYKj+L17A2KUBa2c7gDtKXYz0FLT6
0Bv0pmBN/oYCgVMEBJKqwRwdki9YjEBwyCZwNEx1kDAyyqFEVU9vw/OQfrAdp7MTbuZGFKknVt7b
9wOYy/Op9FiUaTg6SuOy0ep+rqhihltYNAAl4L6fY45mHvqa5vvVG30OvLW/S4uvRYUXYwY6KhWv
NdDf5CnFugnuEZtHJrVe4wx9aO5GvFLFZ/mQ35C5mXPQ7nIb0CDdLBJdz82nUoLSA5BUbeXAUkfa
hW/hLxLdhks68/TK694xVIuiB40pvMmJwxIyDA==',
    ),
  ),
);

/* FINE ARUBA PROD */

$metadata['https://idp.namirialtsp.com/idp'] = array (
  'entityid' => 'https://idp.namirialtsp.com/idp',
  'description' =>
  array (
    'it' => 'Namirial',
  ),
  'OrganizationName' =>
  array (
    'it' => 'Namirial',
  ),
  'name' =>
  array (
    'it' => 'Namirial S.p.a. Trust Service Provider',
  ),
  'OrganizationDisplayName' =>
  array (
    'it' => 'Namirial S.p.a. Trust Service Provider',
  ),
  'url' =>
  array (
    'it' => 'https://www.namirialtsp.com',
  ),
  'OrganizationURL' =>
  array (
    'it' => 'https://www.namirialtsp.com',
  ),
  'contacts' =>
  array (
  ),
  'metadata-set' => 'saml20-idp-remote',
  'sign.authnrequest' => true,
  'SingleSignOnService' =>
  array (
    0 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
      'Location' => 'https://idp.namirialtsp.com/idp/profile/SAML2/POST/SSO',
    ),
    1 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
      'Location' => 'https://idp.namirialtsp.com/idp/profile/SAML2/Redirect/SSO',
    ),
  ),
  'SingleLogoutService' =>
  array (
    0 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
      'Location' => 'https://idp.namirialtsp.com/idp/profile/SAML2/POST/SLO',
    ),
    1 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
      'Location' => 'https://idp.namirialtsp.com/idp/profile/SAML2/Redirect/SLO',
    ),
  ),
  'ArtifactResolutionService' =>
  array (
  ),
  'NameIDFormats' =>
  array (
    0 => 'urn:oasis:names:tc:SAML:2.0:nameid-format:transient',
  ),
  'keys' =>
  array (
    0 =>
    array (
      'encryption' => false,
      'signing' => true,
      'type' => 'X509Certificate',
      'X509Certificate' => 'MIIDNzCCAh+gAwIBAgIUNGvDUjTpLSPlP4sEfO0+JARITnEwDQYJKoZIhvcNAQEL
BQAwHjEcMBoGA1UEAwwTaWRwLm5hbWlyaWFsdHNwLmNvbTAeFw0xNzAzMDgwOTE3
NTZaFw0zNzAzMDgwOTE3NTZaMB4xHDAaBgNVBAMME2lkcC5uYW1pcmlhbHRzcC5j
b20wggEiMA0GCSqGSIb3DQEBAQUAA4IBDwAwggEKAoIBAQDrcJvYRh49nNijgzwL
1OOwgzeMDUWcMSwoWdtMpx3kDhZwMFQ3ITDmNvlz21I0QKaP0BDg/UAjfCbDtLqU
y6wHtI6NWVJoqIziw+dLfg7S5Sr2nOzJ/sKhzadWH1kDsetIenOLU2ex+7Vf/+4P
7nIrS0c+xghi9/zN8dH6+09wWYnloGmcW3qWRFMKJjR3ctBmsmqCKWNIIq2QfeFs
zSSeG0xaNlLKBrj6TyPDxDqPAskq038W1fCuh7aejCk7XTTOxuuIwDGJiYsc8rfX
SG9/auskAfCziGEm304/ojy5MRcNjekz4KgWxT9anMCipv0I2T7tCAivc1z9QCsE
Pk5pAgMBAAGjbTBrMB0GA1UdDgQWBBQi8+cnv0Nw0lbuICzxlSHsvBw5SzBKBgNV
HREEQzBBghNpZHAubmFtaXJpYWx0c3AuY29thipodHRwczovL2lkcC5uYW1pcmlh
bHRzcC5jb20vaWRwL3NoaWJib2xldGgwDQYJKoZIhvcNAQELBQADggEBAEp953KM
WY7wJbJqnPTmDkXaZJVoubcjW86IY494RgVBeZ4XzAGOifa3ScDK6a0OWfIlRTba
KKu9lEVw9zs54vLp9oQI4JulomSaL805Glml4bYqtcLoh5qTnKaWp5qvzBgcQ7i2
GcDC9F+qrsJYreCA7rbHXzF0hu5yIfz0BrrCRWvuWiop92WeKvtucI4oBGfoHhYO
ZsLuoTT3hZiEFJT60xS5Y2SNdz+Eia9Dgt0cvAzoOVk93Cxg+XBdyyEEiZn/zvhj
us29KyFrzh3XYznh+4jq3ymt7Os4JKmY0aJm7yNxw+LyPjkdaB0icfo3+hD7PiuU
jC3Y67LUWQ8YgOc=',
    ),
  ),
);

$metadata['https://spid.register.it'] = array (
  'entityid' => 'https://spid.register.it',
  'description' =>
  array (
    'it' => 'Register S.p.A.',
  ),
  'OrganizationName' =>
  array (
    'it' => 'Register S.p.A.',
  ),
  'name' =>
  array (
    'it' => 'Register S.p.A.',
  ),
  'OrganizationDisplayName' =>
  array (
    'it' => 'Register S.p.A.',
  ),
  'url' =>
  array (
    'it' => 'https//www.register.it',
  ),
  'OrganizationURL' =>
  array (
    'it' => 'https//www.register.it',
  ),
  'contacts' =>
  array (
  ),
  'metadata-set' => 'saml20-idp-remote',
  'sign.authnrequest' => true,
  'SingleSignOnService' =>
  array (
    0 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
      'Location' => 'https://spid.register.it/login/sso',
    ),
    1 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
      'Location' => 'https://spid.register.it/login/sso',
    ),
  ),
  'SingleLogoutService' =>
  array (
    0 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
      'Location' => 'https://spid.register.it/login/singleLogout',
      'ResponseLocation' => 'https://spid.register.it/login/singleLogout/response',
    ),
  ),
  'ArtifactResolutionService' =>
  array (
  ),
  'NameIDFormats' =>
  array (
    0 => 'urn:oasis:names:tc:SAML:2.0:nameid-format:transient',
  ),
  'keys' =>
  array (
    0 =>
    array (
      'encryption' => false,
      'signing' => true,
      'type' => 'X509Certificate',
      'X509Certificate' => 'MIIDazCCAlOgAwIBAgIED8R+MDANBgkqhkiG9w0BAQsFADBmMQswCQYDVQQGEwJJVDELMAkGA1UECBMCRkkxETAPBgNVBAcTCGZsb3JlbmNlMREwDwYDVQQKEwhyZWdpc3RlcjERMA8GA1UECxMIcmVnaXN0ZXIxETAPBgNVBAMTCHJlZ2lzdGVyMB4XDTE3MDcxMDEwMzM0OVoXDTI3MDcwODEwMzM0OVowZjELMAkGA1UEBhMCSVQxCzAJBgNVBAgTAkZJMREwDwYDVQQHEwhmbG9yZW5jZTERMA8GA1UEChMIcmVnaXN0ZXIxETAPBgNVBAsTCHJlZ2lzdGVyMREwDwYDVQQDEwhyZWdpc3RlcjCCASIwDQYJKoZIhvcNAQEBBQADggEPADCCAQoCggEBANkYXHbm3q6xt3wrLAXnytswtj2JE1MM8aYmNXkTgDMCwO/+ahQOoQru6IBTbjfWH9jr+Woy54FDdX6bHl+5/mO6l/yAB/bKgwe5HmUjZJ5oakJjWucsSm+VkEwN2HquBZoN+mktju00xvLX5VAjmDHvZc/b8NhNr/FRKlYITboygkhGiUwGI3wLf3IaB76J0o7ugpW2WNLcywpX+p1VWZAMCdHBveBe/e42hh6WnWPqdwYUWHOgJ8HX4IzCHifiS1n6eUMgtoTQOmSvTQDwSjD0WWJE8tWSYt+txXg1t+3A3tbZOFu7T442wE7DtMdUL4+8gimQS+e8PxDK1uTqIPUCAwEAAaMhMB8wHQYDVR0OBBYEFMCgo1gzCIcUThQIs5g5ikfv1D7eMA0GCSqGSIb3DQEBCwUAA4IBAQBnGw3i3hQ37L8vyelkyZMeO3tLK65Cqti4oVrQZxClGV5zNA6fIMDY8Mci1UhLwjzp29POd/sez0vuHZ/Vmmygzoye4jTKr6c3jAh0u81FTzefBU+vIietm9RuV3sd7D9xq6EqOY1NDL+rkvBcTFtiwLEUm2kHYu/U67jk73pxOtmqxQvQeMU8oi42tehMZGLIGp3U5lGS8YGGl+GtkkQ2Z5/PSm67HGP81kTArG/QX+bX+ykypTJVg9hfb9zOFQidp1HkCRIez6YhDiP/ZLurd6Grt/wVfZPNBO8EOgy25AkRZlp+UD686BFg7qq5KKEbz3qmPrj8deHL3duacZcp',
    ),
  ),
);

// INTESA ID
$metadata['https://spid.intesa.it'] = array (
  'entityid' => 'https://spid.intesa.it',
  'description' =>
  array (
    'it' => 'IN.TE.S.A.
            S.p.A.',
  ),
  'OrganizationName' =>
  array (
    'it' => 'IN.TE.S.A.
            S.p.A.',
  ),
  'name' =>
  array (
    'it' => 'Intesa S.p.A.',
  ),
  'OrganizationDisplayName' =>
  array (
    'it' => 'Intesa S.p.A.',
  ),
  'url' =>
  array (
    'it' => 'https://www.intesa.it/',
  ),
  'OrganizationURL' =>
  array (
    'it' => 'https://www.intesa.it/',
  ),
  'contacts' =>
  array (
  ),
  'metadata-set' => 'saml20-idp-remote',
  'sign.authnrequest' => true,
  'SingleSignOnService' =>
  array (
    0 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
      'Location' => 'https://spid.intesa.it/Time4UserServices/services/idp/AuthnRequest/',
    ),
    1 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
      'Location' => 'https://spid.intesa.it/Time4UserServices/services/idp/AuthnRequest/',
    ),
  ),
  'SingleLogoutService' =>
  array (
    0 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
      'Location' => 'https://spid.intesa.it/Time4UserServices/services/idp/SingleLogout',
      'ResponseLocation' => 'https://spid.intesa.it/Time4UserServices/services/idp/SingleLogout',
    ),
    1 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
      'Location' => 'https://spid.intesa.it/Time4UserServices/services/idp/SingleLogout',
      'ResponseLocation' => 'https://spid.intesa.it/Time4UserServices/services/idp/SingleLogout',
    ),
  ),
  'ArtifactResolutionService' =>
  array (
  ),
  'NameIDFormats' =>
  array (
    0 => 'urn:oasis:names:tc:SAML:2.0:nameid-format:transient',
  ),
  'keys' =>
  array (
    0 =>
    array (
      'encryption' => false,
      'signing' => true,
      'type' => 'X509Certificate',
      'X509Certificate' => 'MIIEDjCCAvagAwIBAgIIIT1A+ywbIQAwDQYJKoZIhvcNAQELBQAwXjEzMDEGA1UE
                        AwwqSU4uVEUuUy5BLiBTLnAuQSAtIENlcnRpZmljYXRpb24gQXV0aG9yaXR5MRow
                        GAYDVQQKDBFJTi5URS5TLkEuIFMucC5BLjELMAkGA1UEBhMCSVQwHhcNMTcwOTE1
                        MTMyMzQ1WhcNMzYwNzAxMTk1OTAwWjBQMSUwDwYDVQQuEwgyMDA3OTc5NzASBgNV
                        BAMMC1NBTUwgU2lnbmVyMRowGAYDVQQKDBFJTi5URS5TLkEuIFMucC5BLjELMAkG
                        A1UEBhMCSVQwggEiMA0GCSqGSIb3DQEBAQUAA4IBDwAwggEKAoIBAQDhYXkP+eQB
                        URgmslDXBjG0ad+DkSAkWt7hUoaTyiK0e34QiyArq043plqTrt+6FzTGeX7960Qr
                        3tCLGCiVOi47QuE09IKfJmKGEaUQnJQehHYZs/XV0OYQl18WrCxUX6ALOcqPs+4y
                        pCbJV1WzSosfBcPBzivJER8kvrynMXI3or18e9XPTGBn8qNFyNF1E3BJ5UhrDvk5
                        W2gKyYKz0M/CIu9PiHuO/ne6HbeNrCS/xzXtjsTusk41AOxIQoFbEzS08xcRY+QD
                        E8oLcAmecSjT3xv3r9dWke6KTTAahS3K+5mOYRcBXj2FFegiUp+xh4OAWdH1+gGD
                        Ym+3aAmMpaLtAgMBAAGjgd0wgdowHQYDVR0OBBYEFEw9xWg4qvQGdlGMCqmJcVDg
                        dE8aMAwGA1UdEwEB/wQCMAAwHwYDVR0jBBgwFoAUySnWJ2sw0ljDpJVrtrxCCP0b
                        1CYwGgYDVR0QBBMwEYAPMjAxNzA5MTUxMzIzNDVaMD8GA1UdHwQ4MDYwNKAyoDCG
                        Lmh0dHA6Ly9lLXRydXN0Y29tLmludGVzYS5pdC9DUkwvSU5URVNBX25DQS5jcmww
                        DgYDVR0PAQH/BAQDAgSwMB0GA1UdJQQWMBQGCCsGAQUFBwMCBggrBgEFBQcDBDAN
                        BgkqhkiG9w0BAQsFAAOCAQEAVRHyFRZZFpW/qjJpKftd86h3wOdUqOhc2W8ZHv0s
                        t8ptG+mZk3l1iWAsEPqKMIBhksgTvalnHC1lHUt11xsZ2mzUjVpiG8XiWXYXQnY2
                        D+q7Dc4n20kJ717qf4SDN8wX1A6XvT3Wrsfh87vg3ZFD56/eyur2snWu4OilsFqA
                        yLhnExG4puJ4JKBWnlwAGXD9SFgkSZ8FC66KQs6CAwVkvCIom3IwJeU/VrYQF6XH
                        kVCQgr5mojXgCkrlRNl53WAKfQHCT4QH+oQVP97PCEL/wQ1zi0UzWauKT6u2wDym
                        9rcpch+WLa0GUtYNhuoLU2SregPKwTWg2DfINJObyWRpww==
                    ',
    ),
  ),
);

// LEPIDA ID

$metadata['https://id.lepida.it/idp/shibboleth'] = array (
		'entityid' => 'https://id.lepida.it/idp/shibboleth',
		'description' =>
		array (
				'it' => 'Lepida S.p.A.',
		),
		'OrganizationName' =>
		array (
				'it' => 'Lepida S.p.A.',
		),
		'name' =>
		array (
				'it' => 'Lepida S.p.A.',
		),
		'OrganizationDisplayName' =>
		array (
				'it' => 'Lepida S.p.A.',
		),
		'url' =>
		array (
				'it' => 'https://www.lepida.it/',
		),
		'OrganizationURL' =>
		array (
				'it' => 'https://www.lepida.it/',
		),
		'contacts' =>
		array (
		),
		'metadata-set' => 'saml20-idp-remote',
		'sign.authnrequest' => true,
		'SingleSignOnService' =>
		array (
				0 =>
				array (
						'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
						'Location' => 'https://id.lepida.it/idp/profile/SAML2/POST/SSO',
				),
				1 =>
				array (
						'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
						'Location' => 'https://id.lepida.it/idp/profile/SAML2/Redirect/SSO',
				),
		),
		'SingleLogoutService' =>
		array (
				0 =>
				array (
						'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
						'Location' => 'https://id.lepida.it/idp/profile/SAML2/POST/SLO',
				),
				1 =>
				array (
						'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
						'Location' => 'https://id.lepida.it/idp/profile/SAML2/Redirect/SLO',
				),
		),
		'ArtifactResolutionService' =>
		array (
		),
		'NameIDFormats' =>
		array (
				0 => 'urn:oasis:names:tc:SAML:2.0:nameid-format:transient',
		),
		'keys' =>
		array (
				0 =>
				array (
						'encryption' => false,
						'signing' => true,
						'type' => 'X509Certificate',
						'X509Certificate' => '
MIIDHDCCAgSgAwIBAgIVALisbudTRxLy3vlMcEDfaqr3iW89MA0GCSqGSIb3DQEB CwUAMBcxFTATBgNVBAMMDGlkLmxlcGlkYS5pdDAeFw0xODA4MDgxMDIzMTJaFw0z ODA4MDgxMDIzMTJaMBcxFTATBgNVBAMMDGlkLmxlcGlkYS5pdDCCASIwDQYJKoZI hvcNAQEBBQADggEPADCCAQoCggEBAMOFERgxPEYPqAjN7oW6y8oSSY6tGm2OCIU+ VyKhb2OqfNLpF8tPrytX17pgwVYHzjxRCNMTC83frbmtBapABtm9KuX7qaSPvaJx 0+UqYk9FdKCKQOEkmWcNOJfwzNMP65B+cDxP3sa1JoAMeAO0x95bnYoX0ZHcssKk wpgMb8/JHZHzqu3odxADtO5PaT3xaCyMIcqIp1O2nVn7SizUE1gNucLAdaP4kh0o 7nU61pz4pG3gQXK+uROteDD8cTU2Nxi7W1T73tQSuwst54BS2p9IBXzWrA9V0Ck1 0oiQTcIC8X9McepCrNzgCOBdap00Tifusb30t74BREARgwjp1N8CAwEAAaNfMF0w HQYDVR0OBBYEFL32/n7uf1Re14pW+gwGxZQHUZBCMDwGA1UdEQQ1MDOCDGlkLmxl cGlkYS5pdIYjaHR0cHM6Ly9pZC5sZXBpZGEuaXQvaWRwL3NoaWJib2xldGgwDQYJ KoZIhvcNAQELBQADggEBAK80B1mEWKOTJkVJOJot2xU79Lhs1+domUSYQiA+tlS4 6IAfWwDZqI1llIjgL85n7qMsKFvYTIskInoG51Iezv2dTxlB6IMI8NPRfiFXo2s8 NYjbzWyETbdXzCbDR0tKNke0TFE0oxunNfE5YRsmH4bPnjhPUjCSHX7wIhlNrLae 3FjMQp1OLDs7HmJo3AhuAVmHCoG7QV/ly4ZHcVYx4F7HUsFg5uxNYjZbo+XMutJz 4nZFOFE+uRzTwwfdR2sxny+ppkruTwIhEXyzknoiw1mGIEWZc6scnOAiwZeqTccU YVNHp+PSFs9SD8l+2PO4Oh8Y3dYT+5ojv+S6T7vy5xE=
					',
				),
		),
);

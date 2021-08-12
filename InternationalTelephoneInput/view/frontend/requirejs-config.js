var config = {
    paths: {
        "intlTelInput": 'Codilar_InternationalTelephoneInput/js/intlTelInput',
        "intlTelInputUtils": 'Codilar_InternationalTelephoneInput/js/utils',
        "internationalTelephoneInput": 'Codilar_InternationalTelephoneInput/js/internationalTelephoneInput'
    },

    shim: {
        'intlTelInput': {
            'deps':['jquery', 'knockout']
        },
        'internationalTelephoneInput': {
            'deps':['jquery', 'intlTelInput']
        }
    }
};

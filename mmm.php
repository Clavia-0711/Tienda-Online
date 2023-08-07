{
    "id": "4LM776220K7187731",
    "intent": "CAPTURE",
    "status": "COMPLETED",
    "purchase_units": [
        {
            "reference_id": "default",
            "amount": {
                "currency_code": "USD",
                "value": "582.00"
            },
            "payee": {
                "email_address": "sb-sv5x41075351@personal.example.com",
                "merchant_id": "T3ZA8NXY8MJA6"
            },
            "soft_descriptor": "PAYPAL *SBSV5X41075",
            "shipping": {
                "name": {
                    "full_name": "John Doe"
                },
                "address": {
                    "address_line_1": "Free Trade Zone",
                    "admin_area_2": "Lima",
                    "admin_area_1": "Lima",
                    "postal_code": "07001",
                    "country_code": "PE"
                }
            },
            "payments": {
                "captures": [
                    {
                        "id": "7UX133717X101781U",
                        "status": "COMPLETED",
                        "amount": {
                            "currency_code": "USD",
                            "value": "582.00"
                        },
                        "final_capture": true,
                        "seller_protection": {
                            "status": "ELIGIBLE",
                            "dispute_categories": [
                                "ITEM_NOT_RECEIVED",
                                "UNAUTHORIZED_TRANSACTION"
                            ]
                        },
                        "create_time": "2023-07-23T23:22:16Z",
                        "update_time": "2023-07-23T23:22:16Z"
                    }
                ]
            }
        }
    ],
    "payer": {
        "name": {
            "given_name": "John",
            "surname": "Doe"
        },
        "email_address": "sb-xkunz26748036@business.example.com",
        "payer_id": "CHEXR3G7FDQ8A",
        "address": {
            "country_code": "PE"
        }
    },
    "create_time": "2023-07-23T23:22:02Z",
    "update_time": "2023-07-23T23:22:16Z",
    "links": [
        {
            "href": "https://api.sandbox.paypal.com/v2/checkout/orders/4LM776220K7187731",
            "rel": "self",
            "method": "GET"
        }
    ]
}
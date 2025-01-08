<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class PagamentoController extends Controller
{
    protected $cliente;

    public function __construct()
    {
        $this->cliente = new \GuzzleHttp\Client();
    }

    // public function chavePublica()
    // {
    //     $response = $this->cliente->request('POST', 'https://sandbox.api.pagseguro.com/public-keys', [
    //         'body' => '{"type":"card"}',
    //         'headers' => [
    //             'Authorization' => '89921c6a-1620-413e-8593-b0b04d2e2c2d9413ae3342bea99dba42b8c7d44c6e182081-31a2-403a-94bf-21c18b73d9f6',
    //             'accept' => '*/*',
    //             'content-type' => 'application/json',
    //         ],
    //     ]);

    //     echo $response->getBody();
    // }

    public function pagamentoCartao(Request $request)
    {
        $inputs = $request->all();

        $nome = isset($inputs["holder"]) ? $inputs["holder"] : NULL;
        $numero = isset($inputs["number"]) ? $inputs["number"] : NULL;
        $ano = isset($inputs["expYear"]) ? $inputs["expYear"] : NULL;
        $mes = isset($inputs["expMonth"]) ? $inputs["expMonth"] : NULL;
        $codigoSeguranca = isset($inputs["securityCode"]) ? $inputs["securityCode"] : NULL;
        $CartaoEncript = isset($inputs["encript"]) ? $inputs["encript"] : NULL;

        $dadosCartao = [
            "reference_id" => "ex-00001",
            "customer" => [
                "name" => "Jose da Silva",
                "email" => "email@test.com",
                "tax_id" => "12345678909",
                "phones" => [
                    [
                        "country" => "55",
                        "area" => "11",
                        "number" => "999999999",
                        "type" => "MOBILE"
                    ]
                ]
            ],
            "items" => [
                [
                    "reference_id" => "referencia do item",
                    "name" => "nome do item",
                    "quantity" => 1,
                    "unit_amount" => 500,
                ]
            ],
            "shipping" => [
                "address" => [
                    "street" => "Avenida Brigadeiro Faria Lima",
                    "number" => "1384",
                    "complement" => "apto 12",
                    "locality" => "Pinheiros",
                    "city" => "São Paulo",
                    "region_code" => "SP",
                    "country" => "BRA",
                    "postal_code" => "01452002"
                ]
            ],
            "notification_urls" => [
                "https://meusite.com/notificacoes"
            ],
            "charges" => [
                [
                    "reference_id" => "referencia da cobranca",
                    "description" => "descricao da cobranca",
                    "amount" => [
                        "value" => 500,
                        "currency" => "BRL"
                    ],
                    "payment_method" => [
                        "type" => "CREDIT_CARD",
                        "installments" => 1,
                        "capture" => TRUE,
                        "card" => [
                            "encrypted" => $CartaoEncript,
                            "store" => TRUE
                        ],
                        "holder" => [
                            "name" => "Jose da Silva",
                            "tax_id" => "65544332211"
                        ]
                    ]
                ]
            ]
        ];

        $dadosCartao = json_encode($dadosCartao);

        try {
            $response = $this->cliente->request('POST', 'https://sandbox.api.pagseguro.com/orders', [
                'headers' => [
                    'Authorization' => '89921c6a-1620-413e-8593-b0b04d2e2c2d9413ae3342bea99dba42b8c7d44c6e182081-31a2-403a-94bf-21c18b73d9f6',
                    'content-type' => 'application/json',
                ],
                "body" => $dadosCartao
            ]);

            return $response->getBody();
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }
    public function pagamentoPix(Request $request)
    {
        $dadosPix = [
            "reference_id" => "ex-00001",
            "customer" => [
                "name" => "Jose da Silva",
                "email" => "email@test.com",
                "tax_id" => "12345678909",
                "phones" => [
                    [
                        "country" => "55",
                        "area" => "11",
                        "number" => "999999999",
                        "type" => "MOBILE"
                    ]
                ]
            ],
            "items" => [
                [
                    "name" => "nome do item",
                    "quantity" => 1,
                    "unit_amount" => 1000
                ]
            ],
            "qr_codes" => [
                [
                    "amount" => [
                        "value" => 1000
                    ],
                    "expiration_date" => Carbon::now()->addDays(2)
                ]
            ],
            "shipping" => [
                "address" => [
                    "street" => "Avenida Brigadeiro Faria Lima",
                    "number" => "1384",
                    "complement" => "apto 12",
                    "locality" => "Pinheiros",
                    "city" => "São Paulo",
                    "region_code" => "SP",
                    "country" => "BRA",
                    "postal_code" => "01452002"
                ]
            ],
            "notification_urls" => [
                "https://meusite.com/notificacoes"
            ]
        ];

        $dadosPix = json_encode($dadosPix);

        try {
            $response = $this->cliente->request('POST', 'https://sandbox.api.pagseguro.com/orders', [
                'headers' => [
                    'Authorization' => '89921c6a-1620-413e-8593-b0b04d2e2c2d9413ae3342bea99dba42b8c7d44c6e182081-31a2-403a-94bf-21c18b73d9f6',
                    'content-type' => 'application/json',
                ],
                "body" => $dadosPix,
            ]);

            echo $response->getBody();
        } catch (\Throwable $th) {
            print_r($th->getMessage());
        }
    }
}

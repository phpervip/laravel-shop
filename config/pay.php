<?php

return [
    'alipay' => [
        'app_id'         => '2016092800619129',
        'ali_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAxG5IkFsGfbMjOQbbZs77LPhSjkw8CmIudg+dnAagZg5O5OlAptf3/ZvUD7SFgkCWOyzW6UWQUhysMCyvXkY1a/KqM0ICTEUVeqliIPuZRMV3JFoJR7nMvbAlho4oRxgFt1ArG032l38gm14Qi99miabPITEQnaY3JlGrLbzP9taWglQJ79BmIDH+W4CYMbdLqwoAnie3QnRx/ELDIOttO5fDB3DGOPZtmyaP2LDXKbXhh1SWrWG+JMsn7h3P+WpgbKtpfFSBJLkD0aQqdP9IwknUCrjsf7DyhvWHG7tOoqvEU4TqRhN1xjFKKMSf7dxfPG9sFtdSDh5ERwAproT3bQIDAQAB',
        'private_key'    => 'MIIEowIBAAKCAQEApeflv+sylT4l0dpWu11Lgml+HSmZiLX2p7AZrQYOj4lqqT7cOkMztycA6qL+sFX1CnGX7K48MLCRIHpEoSKC/N+jSUN2o+pjqTQoWvwODhokPHCVxo9EOCKwaoxOLFwuvL+9tY29ZA86QNCNbky6O6lo3XfZfotVRLG6eyslSdvAJR4Tvsh3oEHqeqQW0ID7qBc8L5fG0YIgSpXFEIXYaBp3eQEZ0OTN+8TxyPz8TQkxLJ50OTpJEYvTI87Ts6GOgLeng44lEVD+akF+n+Ey/dvak85dReXDv3bd6Sb3qpNHwzwQjeNDZN4qOHgKO6jkCkG7ZhC4WxIUx3Gar6kA6wIDAQABAoIBABOuqkwVfB/GirgVvhpmXBHxr/uHtuZIKCYGt1UWld2jgNrpUTk8RcNhxjMP+UU0PWjqxwpWNV/VYrJGryOqs32KjpWfglC5+u7U+ECrDIPRyCC/fpVa484BF4rccF3E5eqQmNIUKbbYM6IC2/SM978iPwWfNVdU8l2+9A+us7LKRSdTZCfcQJ0nkiW/Lo56bX/yt08nRi/mSPurhOGLprtKasnPfdSlMgjIOTHiNs+tKM4MZjiDUbybEess2Bwl5NRUjDdF4AxnRCRcYwcfMggrraBqFnTdcUIOAwYQ5ouNvPQoXjtyeiYup09qHl0S0fYU1aX6PaetscNLDVpof2ECgYEA4rDoqAsDJAW8g5XtqW9sZBzGiN/uK4p0qqIoG5priTJocxR7HbGU6xNyhH46t7BPpP34rS0+9Vt0cSfyNwmV7gR50dlY+ERGGteVmHMVaxO8zMcJ9U/FXaIKlntQRqxyrbmw9QWWcy3w1oWvVY1kV+Lw1lc9l7RKY8pz0YqkWbsCgYEAu1sZ4PGPPxPIGaNxPVnvneL1DwwlGdbsgSaNL90DFmGdI7KlzaBQwMORakrPrdCEt+ayi0GI3irzxb3erUrKTWfQokXx5YHDY3hQL/IMcU6WlQYqrbu4Fcq8nbFW6w8seKdY6ljUjDvGEBlVovXPXM8lkq7hwkFSyhQLsTE0qpECgYEAnwCXL8cJnOqpH2K6IG4XCOFmH/txgvjKfCThHPtjEghZWt6yvFEiswAhAu3HIbB5LLE3C8EAt/g95GCwdAo1L43UJGzfCsRYp9svAo82JrThaIDzay1YsiRGaOZ1mBy9Ez178WDJ9l/y3YVHRiq2hy6W3sCyYwYCZ5xJQGCOhqECgYB2WznA8bi1d1CsaaTqxfrqeeqno9t4NF7Zw7njZ7JAnE/BsmStvr3k2Gbvh+0kd5qv9kwKTs8g0m+HFsgqHxonxhJ1wMvsWYpONz4o27biiWv1Hp0tfW3wTk/TKqmm+sH0QnuYJ5+2KziXCPohZTmm/rFUtaemqM+dGwa73ELSEQKBgHOww7AOAqSVk6UvX3RL9nJx5ab4BNqF+rkLp4ubqGISoNMrmMqJnJDGe+Y8GJUemRPs/K1TviaUOAFrYdhHhy6AWWsBTmD5kaZUP8IFjJ5AKPtTh+733TlA2wMhNFc4yfkCHCn6kCe9QjEtNKFXGGbHFY71sHdO6OWTcnxBImYd',
        'log'            => [
            'file' => storage_path('logs/alipay.log'),
        ],
    ],

    'wechat' => [
        'app_id'      => '',
        'mch_id'      => '',
        'key'         => '',
        'cert_client' => '',
        'cert_key'    => '',
        'log'         => [
            'file' => storage_path('logs/wechat_pay.log'),
        ],
    ],
];

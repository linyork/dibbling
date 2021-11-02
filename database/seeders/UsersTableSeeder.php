<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'api_token' => 'icIKNvAMiYWYGWb0qy7wyVENd6WjNPKu5Bg6IP8PV2RKzw88Y8FHG54V7XRLL4Du',
                'created_at' => '2020-02-04 10:20:27',
                'email' => 'jason@core-tech.tw',
                'email_verified_at' => '2020-02-04 10:20:50',
                'id' => 10,
                'name' => 'Jason',
                'password' => '$2y$10$8irORoxMq2Xr8ZslVEBGBOf3L5RxQ1YS9O2cO79thIq8eqlZA68MK',
                'remember_token' => 'sMgM94J6ufLWknrRUUS7rpG9BdJBkEKipb42XBPaRrJv3Z82Itmbq6J32Ujr',
                'role' => 'user',
                'updated_at' => '2020-06-11 13:01:14',
            ),
            1 => 
            array (
                'api_token' => 'Gwj6PfCQtY9AYtcvwXDIQRFSZ4sBPBNOpvFJIiJVjGYCaRqssXvyYL4HR9AFpbbw',
                'created_at' => '2020-02-05 09:06:52',
                'email' => 'yorklin@core-tech.tw',
                'email_verified_at' => '2020-02-05 09:07:06',
                'id' => 19,
                'name' => 'York',
                'password' => '$2y$10$8irORoxMq2Xr8ZslVEBGBOf3L5RxQ1YS9O2cO79thIq8eqlZA68MK',
                'remember_token' => 'BnZJ3qlTlpBDjGTVjN2HUrEtb4VgbTqxRZDY732TGFIlvRYxnx2NAnoryr54',
                'role' => 'admin',
                'updated_at' => '2021-10-06 17:29:52',
            ),
            2 => 
            array (
                'api_token' => 'prZGL687FA3UGMI2g6mCJ8V2MH7ClOB0SENSVFGEJdEHEY7LrgF8QXYOIuMscYLW',
                'created_at' => '2020-02-04 11:31:35',
                'email' => 'zou-jinji@core-tech.tw',
                'email_verified_at' => '2020-02-04 11:32:04',
                'id' => 21,
                'name' => 'Momoka',
                'password' => '$2y$10$8irORoxMq2Xr8ZslVEBGBOf3L5RxQ1YS9O2cO79thIq8eqlZA68MK',
                'remember_token' => 'NpSQvAvCvXoPQIaOpQZd1TZUze85syvl3ssV22cyFkzBkbFKV11yl8RrLFSy',
                'role' => 'admin',
                'updated_at' => '2020-02-04 11:32:04',
            ),
            3 => 
            array (
                'api_token' => 'pvrBRjwM4JTqb0J3050E8V7WkoOQQtOgoZQXcqgvqy08E9nfRVQtE301CNcIlt6P',
                'created_at' => '2020-02-04 11:31:51',
                'email' => 'futo@core-tech.tw',
                'email_verified_at' => '2020-02-04 11:31:58',
                'id' => 22,
                'name' => 'Futo',
                'password' => '$2y$10$8irORoxMq2Xr8ZslVEBGBOf3L5RxQ1YS9O2cO79thIq8eqlZA68MK',
                'remember_token' => 'Vtzg5B9KetmSmblYAWHMBqK8J092Dw0R4TGfCN9kM3sQMMFz3S18U6ITtnwZ',
                'role' => 'user',
                'updated_at' => '2020-02-04 11:31:58',
            ),
            4 => 
            array (
                'api_token' => 'GYWpUjXWNA3SPbGzIAtkJI1BfPrUHDekLZ8ccFAYGD2UQJBPk8Z0sduUn0e28k8V',
                'created_at' => '2020-02-04 11:31:59',
                'email' => 'watanabe@core-tech.tw',
                'email_verified_at' => '2020-02-04 11:33:22',
                'id' => 23,
                'name' => 'Watanabe',
                'password' => '$2y$10$8irORoxMq2Xr8ZslVEBGBOf3L5RxQ1YS9O2cO79thIq8eqlZA68MK',
                'remember_token' => 'aR3c2v3cahDgVB4E8tOTm8BxX9nBXH5cY2ztw17PumAanjLUFpeOukAdiekC',
                'role' => 'admin',
                'updated_at' => '2020-02-04 11:33:22',
            ),
            5 => 
            array (
                'api_token' => 'ejMF0XE74o99ZAmTD1GVRJZzbuIDDJB2UMX4vZHzL00m43Zf9TU54FMfytdhlbb7',
                'created_at' => '2020-02-04 11:49:10',
                'email' => 'unohung@core-tech.tw',
                'email_verified_at' => '2020-02-04 11:50:31',
                'id' => 27,
                'name' => 'Uno',
                'password' => '$2y$10$8irORoxMq2Xr8ZslVEBGBOf3L5RxQ1YS9O2cO79thIq8eqlZA68MK',
                'remember_token' => '2BvBHqzIkhfl5QWyf2f0obR7B3GbkzKqyM26LXR5ct7Eh4pG8RfgeWuGdMHe',
                'role' => 'user',
                'updated_at' => '2020-02-04 11:50:31',
            ),
            6 => 
            array (
                'api_token' => '2vEqBRzWjBlk81LoSbRf1s33St8NPq2EloDGsSCD9p5LOtfEw7Zuabm5WYPKfhId',
                'created_at' => '2020-02-04 12:12:48',
                'email' => 'elliot@core-tech.tw',
                'email_verified_at' => '2020-02-04 12:12:59',
                'id' => 29,
                'name' => 'Elliot',
                'password' => '$2y$10$8irORoxMq2Xr8ZslVEBGBOf3L5RxQ1YS9O2cO79thIq8eqlZA68MK',
                'remember_token' => 'kHRjdT5Vf7sWYJBVsjYIh0cfLvUMrOWvIqoGT7gJnQ7z9DNa020jXa9Mu45b',
                'role' => 'user',
                'updated_at' => '2020-02-04 12:12:59',
            ),
            7 => 
            array (
                'api_token' => 'fjYdVSsasfxthRSiZM2sbX4uZE70jfbgI5QxJrdBy7TgyvnJqIm1aypHyGFm6XaG',
                'created_at' => '2020-02-04 14:10:08',
                'email' => 'circle.tsao@core-tech.tw',
                'email_verified_at' => '2020-02-04 14:10:29',
                'id' => 31,
                'name' => 'Ashley Tsao',
                'password' => '$2y$10$8irORoxMq2Xr8ZslVEBGBOf3L5RxQ1YS9O2cO79thIq8eqlZA68MK',
                'remember_token' => 'shrS2N4QdPJbku0NAwrLmYztqvN8yWyBMfRL4i58f2dESur6rUsG7mzZ9mLo',
                'role' => 'user',
                'updated_at' => '2020-02-04 14:10:29',
            ),
            8 => 
            array (
                'api_token' => 't9CJJ2TW622USf5lba143PaxogwTHVjW0olKGOrdvJU56k0ME4pluhftTcQU0mkk',
                'created_at' => '2020-02-04 17:57:22',
                'email' => 'whitney@core-tech.tw',
                'email_verified_at' => '2020-02-04 17:58:12',
                'id' => 47,
                'name' => 'Whitney',
                'password' => '$2y$10$8irORoxMq2Xr8ZslVEBGBOf3L5RxQ1YS9O2cO79thIq8eqlZA68MK',
                'remember_token' => 'sn9pJ6RzQqW6DtLMl2KN0rBte79C2NxTDq6B4W7Aj8WjSt8K73iaOWBraJxq',
                'role' => 'user',
                'updated_at' => '2020-02-04 17:58:12',
            ),
            9 => 
            array (
                'api_token' => 'PDU4R83Uz9BzOu8e3TfBYbq9OGmV20l9v4SFoaVzsmA6jJCW5Em7ztkbp73g9UTV',
                'created_at' => '2020-02-05 09:08:14',
                'email' => 'jimmyjun@core-tech.tw',
                'email_verified_at' => '2020-02-05 09:08:25',
                'id' => 51,
                'name' => 'Jimmy Ou',
                'password' => '$2y$10$8irORoxMq2Xr8ZslVEBGBOf3L5RxQ1YS9O2cO79thIq8eqlZA68MK',
                'remember_token' => 'fURlNSPI6DG2O0osUz7Ans60FyVgm04JpZNF82guY0DVCFjQGe95sGlJFdGx',
                'role' => 'user',
                'updated_at' => '2020-02-05 09:08:25',
            ),
            10 => 
            array (
                'api_token' => 'fyw2CKGJ0RiJoxvbb8sL6PO39DNtQPtKGPPwbGfr7FcazKkVG0sj2oHWxxeE0LHj',
                'created_at' => '2020-02-05 09:42:28',
                'email' => 'roywen@core-tech.tw',
                'email_verified_at' => '2020-02-05 09:43:10',
                'id' => 52,
                'name' => 'Roy',
                'password' => '$2y$10$8irORoxMq2Xr8ZslVEBGBOf3L5RxQ1YS9O2cO79thIq8eqlZA68MK',
                'remember_token' => 'XxvZn7bWyx4ZcneFL1sZPAAEub1fGQJEq44nBJs8XJxM79szuVWyMYStEC7t',
                'role' => 'user',
                'updated_at' => '2020-02-05 09:43:10',
            ),
            11 => 
            array (
                'api_token' => 'koswoGHtAtA74ui5h4ooW7G0bnN6zvRnRJXv5GORVKvyUgmnIvvCDDtIJccU1Qrt',
                'created_at' => '2020-02-05 15:41:26',
                'email' => 'heatlai@core-tech.tw',
                'email_verified_at' => '2020-02-05 15:41:48',
                'id' => 56,
                'name' => 'Heat',
                'password' => '$2y$10$8irORoxMq2Xr8ZslVEBGBOf3L5RxQ1YS9O2cO79thIq8eqlZA68MK',
                'remember_token' => 'lsYF5juIjGdJRnPruTbmKKqKpun4sTzagdRCVXM48zyzXaD5T8kNpi0nVkOn',
                'role' => 'user',
                'updated_at' => '2020-02-05 15:41:48',
            ),
            12 => 
            array (
                'api_token' => '5NpFNyputUqnmRSdwlmeV7tfftwBWno0CQiKo2xVnHfuKKU5R9VzA72R7aoLljq0',
                'created_at' => '2020-02-05 16:01:43',
                'email' => 'novazhang@core-tech.tw',
                'email_verified_at' => '2020-02-05 18:04:43',
                'id' => 58,
                'name' => 'Nova',
                'password' => '$2y$10$8irORoxMq2Xr8ZslVEBGBOf3L5RxQ1YS9O2cO79thIq8eqlZA68MK',
                'remember_token' => NULL,
                'role' => 'user',
                'updated_at' => '2020-02-05 18:04:43',
            ),
            13 => 
            array (
                'api_token' => 'Qp9HUvManvHwGh1NZ3ukXcfNJjGAIPigAfZAYUNAHQ20p7fQufjyafYoa9cU2DhN',
                'created_at' => '2020-02-05 16:17:10',
                'email' => 'fukushima@core-tech.tw',
                'email_verified_at' => '2020-02-05 16:17:39',
                'id' => 59,
                'name' => 'Fukushima',
                'password' => '$2y$10$8irORoxMq2Xr8ZslVEBGBOf3L5RxQ1YS9O2cO79thIq8eqlZA68MK',
                'remember_token' => 'w6cMOOUVWGVmdeJBsbniNiZIRG3CCRz2TQz3ibDETvh1CjVegHczrrlhI7kD',
                'role' => 'user',
                'updated_at' => '2021-05-12 17:46:54',
            ),
            14 => 
            array (
                'api_token' => 'rWBuabHZTygciRlNANCLqdoxLyANeHyScfkrdttN9yN3jN0ZXWZ1LcRXONTDpECs',
                'created_at' => '2020-02-06 17:43:51',
                'email' => 'baibai@core-tech.tw',
                'email_verified_at' => '2020-02-06 17:44:18',
                'id' => 60,
                'name' => 'Baibai',
                'password' => '$2y$10$8irORoxMq2Xr8ZslVEBGBOf3L5RxQ1YS9O2cO79thIq8eqlZA68MK',
                'remember_token' => 'GuC2vnNnhPFAg2hmaMlkf5OxAQ05912ABbFJJ2JZldScaGpmkKJYiX8xnINe',
                'role' => 'user',
                'updated_at' => '2020-02-06 17:44:18',
            ),
            15 => 
            array (
                'api_token' => 'PMVSTvDAdUw5tdNIwvIfSP7o2X4km6y8kScZPwDbauDouQbakDXCRuAqSCH7fib1',
                'created_at' => '2020-02-06 17:48:02',
                'email' => 'sumiko@core-tech.tw',
                'email_verified_at' => '2020-02-06 17:48:14',
                'id' => 62,
                'name' => 'Sumiko',
                'password' => '$2y$10$8irORoxMq2Xr8ZslVEBGBOf3L5RxQ1YS9O2cO79thIq8eqlZA68MK',
                'remember_token' => 'CvvX82PNqKJ4V3G9uiAiCdAYdBWvTeJBbCw6bXrdiepPI2mbQ3E9SCplbmvf',
                'role' => 'user',
                'updated_at' => '2020-02-06 17:48:14',
            ),
            16 => 
            array (
                'api_token' => 'NpA2zkGESa1L0Dm4nnn7ZJOxB8cm80d1niretSQXqv0T5DcoyZwpWCSEJ7JrtXB6',
                'created_at' => '2020-02-11 14:02:22',
                'email' => 'mikechen@core-tech.tw',
                'email_verified_at' => '2020-02-11 14:02:59',
                'id' => 63,
                'name' => 'Mike',
                'password' => '$2y$10$8irORoxMq2Xr8ZslVEBGBOf3L5RxQ1YS9O2cO79thIq8eqlZA68MK',
                'remember_token' => NULL,
                'role' => 'user',
                'updated_at' => '2020-02-11 14:02:59',
            ),
            17 => 
            array (
                'api_token' => 'Z5KXxd5ByHdm883Fb5PFl7sUpCz5WMg61Bv6UETaSYngdhLjtiJoB2z9bt3ZLsYB',
                'created_at' => '2020-02-17 16:05:03',
                'email' => 'kylewang@core-tech.tw',
                'email_verified_at' => '2020-02-17 16:05:22',
                'id' => 67,
                'name' => 'Kyle',
                'password' => '$2y$10$8irORoxMq2Xr8ZslVEBGBOf3L5RxQ1YS9O2cO79thIq8eqlZA68MK',
                'remember_token' => 'mYByCUkIpgD5wPeQSACYjVShz6cIn12F02DK3h93ehiwoOo4x8xvtOEEZ0cO',
                'role' => 'user',
                'updated_at' => '2020-04-20 12:21:17',
            ),
            18 => 
            array (
                'api_token' => '55LPem0FczLwvzOemlH0ME3i9VAmLlRPHhELAIGLEh87LGJp1R7Wq6ZOLD6Gezzg',
                'created_at' => '2020-02-24 10:12:37',
                'email' => 'tonyxu@core-tech.tw',
                'email_verified_at' => '2020-02-24 10:13:25',
                'id' => 68,
                'name' => 'DC',
                'password' => '$2y$10$8irORoxMq2Xr8ZslVEBGBOf3L5RxQ1YS9O2cO79thIq8eqlZA68MK',
                'remember_token' => 'yMuBl8bIrj7ZT54c4oMr2jziBtwXs6pOdQLTYPVNPtY43J7kE7Q4cOzhvzz2',
                'role' => 'user',
                'updated_at' => '2020-02-24 10:13:25',
            ),
            19 => 
            array (
                'api_token' => 'q45R9V8RZmrqCbel75h8mQpc3rkK5L1H1I3f8s9EM1iGt4JjmoGzhomA9VBCYtY1',
                'created_at' => '2020-03-06 11:05:51',
                'email' => 'apolin@core-tech.tw',
                'email_verified_at' => '2020-03-06 11:06:33',
                'id' => 69,
                'name' => 'Apo',
                'password' => '$2y$10$8irORoxMq2Xr8ZslVEBGBOf3L5RxQ1YS9O2cO79thIq8eqlZA68MK',
                'remember_token' => 'w5j4tKqr9hQqlX2nv0rHuU3LcyEEQeg4xTF8XEKoDpZQpdxWY7rqEcJ3QshK',
                'role' => 'user',
                'updated_at' => '2020-03-06 11:06:33',
            ),
            20 => 
            array (
                'api_token' => 'eaTkVxWyASZugiAzJAulBAvNkiIUbIA3uy22F5OZKmB6JoliyYYjGf5ERpTPaE2v',
                'created_at' => '2020-03-16 09:35:32',
                'email' => 'jimmy@core-tech.tw',
                'email_verified_at' => '2020-03-16 09:35:32',
                'id' => 70,
                'name' => 'Jimmy',
                'password' => '$2y$10$8irORoxMq2Xr8ZslVEBGBOf3L5RxQ1YS9O2cO79thIq8eqlZA68MK',
                'remember_token' => '1IAi97FIsOTOTPt2RH90koziD3hKEJrk5Ht8GjsCFqRtBecAwmLGa33bhuDY',
                'role' => 'user',
                'updated_at' => '2020-04-13 17:13:23',
            ),
            21 => 
            array (
                'api_token' => '1ehmt3SiF0UhaypmGBGm6x6eyXrGLZhOO972xjOPSrDZEImJNfENPNYKmIiAIe2C',
                'created_at' => '2020-03-25 09:14:15',
                'email' => 'goulin@core-tech.tw',
                'email_verified_at' => '2020-03-25 09:15:40',
                'id' => 74,
                'name' => 'Gou Lin',
                'password' => '$2y$10$8irORoxMq2Xr8ZslVEBGBOf3L5RxQ1YS9O2cO79thIq8eqlZA68MK',
                'remember_token' => 'H70lyn8ffEmNtuBUn0CDbN6UH4aZbnfee1991AOOIB5RCmNjI9RG7G6AKemN',
                'role' => 'user',
                'updated_at' => '2020-03-25 09:15:40',
            ),
            22 => 
            array (
                'api_token' => 'BhfVuA3SdxeWP71mXewf8Jyv4ZtNKFjIJneuK4HI89g8QA4oXcUJVfs8nKdyTBaF',
                'created_at' => '2020-04-22 17:57:02',
                'email' => 'lilyyeh@core-tech.tw',
                'email_verified_at' => '2020-04-22 17:57:55',
                'id' => 77,
                'name' => 'LilyYeh',
                'password' => '$2y$10$8irORoxMq2Xr8ZslVEBGBOf3L5RxQ1YS9O2cO79thIq8eqlZA68MK',
                'remember_token' => NULL,
                'role' => 'user',
                'updated_at' => '2020-04-22 17:57:55',
            ),
            23 => 
            array (
                'api_token' => 'NVIyfvQSZkBXghFH2QmOvhsnJWf0tdYvDrvLxCACQVbKD92Y21BFuzGZlywHcw1L',
                'created_at' => '2020-06-02 10:13:53',
                'email' => 'jeffchai@core-tech.tw',
                'email_verified_at' => '2020-06-02 10:14:05',
                'id' => 78,
                'name' => 'Jeff',
                'password' => '$2y$10$8irORoxMq2Xr8ZslVEBGBOf3L5RxQ1YS9O2cO79thIq8eqlZA68MK',
                'remember_token' => 'XxqaJETbp107VgM1Ik08VJC9IyYNZuB4i8pOGrLSoBshmB10vYqJiCJeRFyA',
                'role' => 'user',
                'updated_at' => '2020-06-02 10:14:05',
            ),
            24 => 
            array (
                'api_token' => 'YDhp3ThcRcYpJcCje44cceR7HDCDMQynPhjWVE2kUrKOsaDB4tAWQOyAJLeBmYIC',
                'created_at' => '2020-09-01 14:55:58',
                'email' => 'yukoran@core-tech.tw',
                'email_verified_at' => '2020-09-01 14:56:10',
                'id' => 79,
                'name' => 'Yuko',
                'password' => '$2y$10$8irORoxMq2Xr8ZslVEBGBOf3L5RxQ1YS9O2cO79thIq8eqlZA68MK',
                'remember_token' => 'mrGvJ8lpIxRYyJ152YmphuJ7JDQYVNg6ljl61YIVv08VvZybJv0aD6Cx6El8',
                'role' => 'user',
                'updated_at' => '2020-09-01 14:56:10',
            ),
            25 => 
            array (
                'api_token' => 'fwYoP0Gyltr5tqyWToSMdyoMVWUAM4nLB0Xf5orAbOlw7Xzrlx0IFzxWhAJukyu2',
                'created_at' => '2020-11-11 10:39:17',
                'email' => 'paul-liu@core-tech.tw',
                'email_verified_at' => '2020-11-11 10:39:30',
                'id' => 80,
                'name' => 'paul-liu',
                'password' => '$2y$10$8irORoxMq2Xr8ZslVEBGBOf3L5RxQ1YS9O2cO79thIq8eqlZA68MK',
                'remember_token' => 'KzZTnL9k3lfR4S4JnpcxXLbmFlT6L3HJ1k6SB0V3JbxBooB1UjS2kgh4d4CX',
                'role' => 'user',
                'updated_at' => '2020-12-10 12:30:35',
            ),
            26 => 
            array (
                'api_token' => 'Iy7ihzln4wpoQdIvr2M3r7WfDOQcbih1WRld4x7j5Z78gFg177j48TdN6HsZOEv3',
                'created_at' => '2021-03-31 11:47:35',
                'email' => 'markchen@core-tech.tw',
                'email_verified_at' => '2021-03-31 11:48:17',
                'id' => 81,
                'name' => 'MarkChen',
                'password' => '$2y$10$8irORoxMq2Xr8ZslVEBGBOf3L5RxQ1YS9O2cO79thIq8eqlZA68MK',
                'remember_token' => 'QgZPeTgW1XGrF5WcrQ4FaSpQYMDgK8YakvBOyvqn2XNl3DnIPGEqMhacL1EN',
                'role' => 'user',
                'updated_at' => '2021-03-31 11:48:17',
            ),
            27 => 
            array (
                'api_token' => 'B5MRmb5ECn2MlnqlUmFK0SY6arzTogkwkSswush5Ss26AcLr57l7OxawsiNntlwV',
                'created_at' => '2021-08-23 09:47:13',
                'email' => 'huaenhsu@core-tech.tw',
                'email_verified_at' => '2021-08-23 09:47:44',
                'id' => 82,
                'name' => 'kaon',
                'password' => '$2y$10$8irORoxMq2Xr8ZslVEBGBOf3L5RxQ1YS9O2cO79thIq8eqlZA68MK',
                'remember_token' => NULL,
                'role' => 'user',
                'updated_at' => '2021-08-23 09:47:44',
            ),
            28 => 
            array (
                'api_token' => 'qSj6cOeOYnQkfksFkLzrfi0KpsEsa69ToCSdYjEcu4mol4jR3C90GPZJXHQ2uOIN',
                'created_at' => '2021-10-06 15:56:17',
                'email' => 'christine@core-tech.tw',
                'email_verified_at' => '2021-10-06 15:56:38',
                'id' => 83,
                'name' => 'christine',
                'password' => '$2y$10$8irORoxMq2Xr8ZslVEBGBOf3L5RxQ1YS9O2cO79thIq8eqlZA68MK',
                'remember_token' => 'NqfSw7C2OBYwJHmt0KmVdqc66uhftbj4RAqDd4GE8kTAtVltCbixOqWCJtgR',
                'role' => 'user',
                'updated_at' => '2021-10-06 15:56:38',
            ),
        ));
        
        
    }
}
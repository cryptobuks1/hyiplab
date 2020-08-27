<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        body {
            background: #dde6ec;
        }

        .pay_form {
            background: #b4d0e2;
            border-radius: 30px;
            overflow: hidden;
            margin-top: 100px;
            color: #16657c;
            font-size: 13px;
        }

        .pay_form_title {
            font-weight: bold;
            padding: 15px 0;
            font-size: 18px;
        }

        .pay_form_body {
            background: #fff;
            padding: 30px;
            min-height: 100px;
            border-radius: 30px 30px 0 0;
            overflow: hidden;
        }

        .pay_form label {
            display: block;
        }

        .pay_form .form-control {
            background: #dde6ec;
            border: none;
            border-radius: 50px;
            color: #16657c;
            font-weight: 700;
            margin: 5px 0;
        }

        .pay_form_bal {
            font-weight: 700;
            font-size: 18px;
            position: relative;
            top: 30px;
        }

        .pay_form_qr {
            width: 100%;
            height: auto;
            border: 2px solid #eee;
            font-weight: 700;
            min-height: 100px;
        }

        .pay_form_line {
            width: 100%;
            height: 2px;
            background: #dde6ec;
        }

        .btn-success {
            font-weight: 700;
            font-size: 18px;
            background: #3e92ab;
            border: none;
            border-radius: 50px;
            padding: 10px 35px;
        }

        .btn-success:hover {
            background: #3e92ab;
            opacity: 0.7;
        }

    </style>

    <title>Pay with Ethereum</title>
</head>
<body>
<div class="container-fluid main_container">
    <div class="row">
        <div class="container">
            <div class="row">
                <div class="col-lg-3"></div>
                <div class="col-lg-6">
                    <div class="pay_form">
                        <div class="pay_form_title text-center">Recharge balance with Ethereum</div>
                        <div class="pay_form_body">

                                <div class="row">
                                    <div class="col-lg-6">
                                        <label for="">
                                            You should send
                                            <input type="text" value="{{ $transaction->amount }}" name="" id="" readonly="" class="form-control">
                                        </label>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="pay_form_bal">ETH</div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <label for="">
                                            To ETH address:
                                            <input type="text" value="{{ $transaction->source }}" readonly name="" id="" class="form-control">
                                        </label>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6 text-right">
                                        24 hours timeout
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-4"></div>
                                    <div class="col-lg-4">
                                        <div class="pay_form_qr text-center">
                                            <a rel='nofollow' href='{{ $paymentSystem->code.':'.$transaction->source.'?amount='.$transaction->amount }}' border='0'><img src='https://chart.googleapis.com/chart?cht=qr&chl={{ urlencode($paymentSystem->code.':'.$transaction->source.'?amount='.$transaction->amount) }}&chs=180x180&choe=UTF-8&chld=L|2' alt=''></a>
                                        </div>
                                    </div>
                                    <div class="col-lg-4"></div>
                                </div>

                                <div class="pay_form_line mt-3 mb-3"></div>

                                <div class="row">
                                    <div class="col-lg-12 text-center">
                                        Transaction info: <a href="https://etherscan.io/address/{{ $transaction->source }}" target="_blank" class="d-inline">
                                            https://etherscan.io/address/{{ $transaction->source }}
                                        </a>
                                    </div>
                                </div>

                                <div class="row mt-3 text-center">
                                    <div class="col-lg-12">
                                        All operations processing automatically. It can take up to couple of hours.
                                    </div>

                                    <div class="col-lg-12 mt-3">
                                        <button type="submit" class="btn btn-success" onclick="location.assign('{{ route('profile.profile') }}')">
                                            I paid
                                        </button>
                                    </div>
                                </div>

                        </div>
                    </div>
                </div>
                <div class="col-lg-3"></div>
            </div>
        </div>
    </div>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
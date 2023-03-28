<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BARCODE - {{ $code }}</title>
</head>
<style>
    table {
        max-width: 300px;
    }

    .text-center {
        text-align: center;
    }

    @page {
        margin-top: 100px;
        /* create space for header */
        margin-bottom: 70px;
        /* create space for footer */
    }

    header,
    footer {
        position: fixed;
        left: 0px;
        right: 0px;
    }

    header {
        height: 40px;
        margin-top: -60px;
    }

    .column {
        float: left;
        width: 50%;
    }

    .row:after {
        content: "";
        display: table;
        clear: both;
    }
</style>

<body>
    <header>
        <div class="row">
            <div class="column" style="text-align: left"><img src="data:image/png;base64, {{ base64_encode($qrcode) }} ">
            </div>
            <div class="column" style="text-align: right"><img src="{{ asset('images/logo.png') }}" alt="tag" height="30px"></div>
        </div>
    </header>
    <table border='1' width='100%' style='border-collapse: collapse;'>
        <tr style="background-color: #032A42; color:aliceblue" class="text-center">
            <td colspan="4">
                <h2>{{ $code }}</h2>
            </td>
        </tr>
        <tr>
            <td colspan="1">
                <h3>CLIENTE </h3>
            </td>
            <td colspan="3" style="padding-left: 5px"> {{ $customer }}</td>
        </tr>
        <tr>
            <td>
                <h3>COD </h3>
            </td>
            <td> {{ $code }}</td>
            <td>
                <h3>ITEM </h3>
            </td>
            <td style="padding-left: 5px"> {{ $quantity }}</td>
        </tr>
    </table>
    <div>
        <table width='100%' style='border-collapse: collapse;'>
            <tr>
                <td class="text-center">
                    <h3>www.fenixcargo.com.br</h3>
                </td>
            </tr>
            <tr>
                <td class="text-center">
                    <h2>0800 031 0302</h2>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>

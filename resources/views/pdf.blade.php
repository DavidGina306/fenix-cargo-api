<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BARCODE</title>
</head>
<style>
    table {
        max-width: 300px;
    }
    .text-center {
        text-align: center;
    }
</style>

<body>
    <table  border='1' width='100%' style='border-collapse: collapse;'>
        <tr style="background-color: #032A42; color:aliceblue" class="text-center" >
            <td colspan="4">
                <h1>{{ $code }}</h1>
            </td>
        </tr>
        <tr>
            <td colspan="1">
                <h2>CLIENTE </h2>
            </td>
            <td colspan="3"> {{ $customer }}</td>
        </tr>
        <tr>
            <td>
                <h3>COD </h3>
            </td>
            <td> {{ $code }}</td>
            <td>
                <h3>ITEM </h3>
            </td>
            <td> {{ $code }}</td>
        </tr>
    </table>
    <div>
        <table width='100%' style='border-collapse: collapse;'>
            <tr>
                <td class="text-center"> <h2>www.fenixcargo.com.br</h2></td>
            </tr>
            <tr>
                <td class="text-center"><h1>0800 031 0302</h1></td>
            </tr>
        </table>
    </div>
</body>

</html>

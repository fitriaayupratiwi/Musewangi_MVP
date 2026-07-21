<!doctype html>More actions
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Invoice Transaksi</title>

    <style type="text/css">
        * {
            font-family: Verdana, Arial, sans-serif;
        }

        table {
            font-size: x-small;
        }

        tfoot tr td {
            font-weight: bold;
            font-size: x-small;
        }

        .gray {
            background-color: lightgray
        }

        .font {
            font-size: 15px;
        }

        .authority {
            /*text-align: center;*/
            float: right
        }

        .authority h5 {
            margin-top: -10px;
            color: #007BFF;
            /*text-align: center;*/
            margin-left: 35px;
        }

        .thanks p {
            color: #007BFF;
            ;
            font-size: 16px;
            font-weight: normal;
            font-family: serif;
            margin-top: 20px;
        }
    </style>

</head>

<body>

    <table width="100%" style="background: #F7F7F7; padding:0 20px 0 20px;">
        <tr>
            <td valign="top">
                <!-- {{-- <img src="" alt="" width="150"/> --}} -->
                <h2 style="color: #007BFF; font-size: 26px;"><strong>Warung Seblang</strong></h2>
            </td>

        </tr>

    </table>


    <table width="100%" style="background:white; padding:2px;"></table>

    <table width="100%" style="background: #F7F7F7; padding:0 5 0 5px;" class="font">
        <tr>
            <td>
                <p class="font" style="margin-left: 20px;">
                    <strong>Tanggal:</strong> {{ $transaksi->created_at->format('d M Y H:i') }} <br>
                    <strong>Nomor Meja:</strong> {{ $transaksi->nomor_meja }} <br>
                    <strong>Metode Pembayaran:</strong> {{ $transaksi->metode_pembayaran }} <br>



                </p>
            </td>

        </tr>
    </table>
    <br />
    <h3>Products</h3>


    <table width="100%">
        <thead style="background-color: #007BFF; color:#FFFFFF;">
            <tr class="font">

                <th>Nama</th>
                <th>Jumlah</th>
                <th>Harga </th>
            </tr>
        </thead>
        <tbody>


            @foreach ($details as $item)
                <tr>
                    <td>{{ $item['nama'] }}</td>
                    <td>{{ $item['jumlah'] }}</td>
                    <td>{{ number_format($item['harga'], 0, ',', '.') }}</td>
                </tr>
            @endforeach


        </tbody>
    </table>
    <br>
    <table width="100%" style=" padding:0 10px 0 10px;">
        <tr>
            <td align="right">

                <h2><span style="color: #007BFF;">Total:</span>
                    {{ $totalPrice }}</h2>
                {{-- <h2><span style="color: #007BFF;">Full Payment PAID</h2> --}}
            </td>
        </tr>
    </table>
    <div class="thanks mt-3">
        <p>Terima Kasih Telah Membeli Produk</p>
    </div>
    <div class="authority float-right mt-5">
        <p>-----------------------------------</p>
        <h5>Admin Warung Seblang</h5>
    </div>
</body>

</html>
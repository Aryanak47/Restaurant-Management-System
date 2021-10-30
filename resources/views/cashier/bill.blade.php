<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>A simple, clean, and responsive HTML invoice template</title>

		<style>
			.invoice-box {
				max-width: 800px;
				margin: auto;
				padding: 30px;
				border: 1px solid #eee;
				box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
				font-size: 16px;
				line-height: 24px;
				font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
				color: #555;
			}

			.invoice-box table {
				width: 100%;
				line-height: inherit;
				text-align: left;
			}

			.invoice-box table td {
				padding: 5px;
				vertical-align: top;
			}

			.invoice-box table tr td:nth-child(2) {
				text-align: right;
			}

			.invoice-box table tr.top table td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.top table td.title {
				font-size: 45px;
				line-height: 45px;
				color: #333;
			}

		

			.invoice-box table tr.heading td {
				background: #eee;
				border-bottom: 1px solid #ddd;
				font-weight: bold;
			}

		

			.invoice-box table tr.item td {
				border-bottom: 1px solid #eee;
			}

			.invoice-box table tr.item.last td {
				border-bottom: none;
			}

			.invoice-box table tr.total td:nth-child(2) {
				border-top: 2px solid #eee;
				font-weight: bold;
			}

			@media only screen and (max-width: 600px) {
				.invoice-box table tr.top table td {
					width: 100%;
					display: block;
					text-align: center;
				}

				.invoice-box table tr.information table td {
					width: 100%;
					display: block;
					text-align: center;
				}
			}

			/** RTL **/
			.invoice-box.rtl {
				direction: rtl;
				font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
			}

			.invoice-box.rtl table {
				text-align: right;
			}

			.invoice-box.rtl table tr td:nth-child(2) {
				text-align: left;
			}
            .restaurant_name{
                font-size:16px;
            }
            .btn {
                appearance: button;
                backface-visibility: hidden;
                background-color: #405cf5;
                border-radius: 6px;
                border-width: 0;
                box-shadow: rgba(50, 50, 93, .1) 0 0 0 1px inset,rgba(50, 50, 93, .1) 0 2px 5px 0,rgba(0, 0, 0, .07) 0 1px 1px 0;
                box-sizing: border-box;
                color: #fff;
                cursor: pointer;
                font-family: -apple-system,system-ui,"Segoe UI",Roboto,"Helvetica Neue",Ubuntu,sans-serif;
                font-size: 100%;
                height: 44px;
                line-height: 1.15;
                margin: 12px 0 0;
                outline: none;
                overflow: hidden;
                padding: 0 25px;
                position: relative;
                text-align: center;
                text-transform: none;
                transform: translateZ(0);
                transition: all .2s,box-shadow .08s ease-in;
                user-select: none;
                -webkit-user-select: none;
                touch-action: manipulation;
                width: 100%;
            }

        .btn:disabled {
        cursor: default;
        }

        .btn:focus {
        box-shadow: rgba(50, 50, 93, .1) 0 0 0 1px inset, rgba(50, 50, 93, .2) 0 6px 15px 0, rgba(0, 0, 0, .1) 0 2px 2px 0, rgba(50, 151, 211, .3) 0 0 0 4px;
        }

        .back-button {
        background-color: #6E6D70;

        }
	</style>
	</head>

	<body>
		<div class="invoice-box">
			<table cellpadding="0" cellspacing="0">
				<tr class="top">
					<td colspan="2">
						<table>
							<tr>
								<td>
									<h2 class="restaurant_name">Restaurant Name</h2>
								</td>

								<td>
									Date: <span>{{Date("y-m-d",strtotime($sale->created_at))}}</span><br />
                                    kathmandu,naxal<br />
								</td>
							</tr>
						</table>
					</td>
				</tr>

				<tr class="heading">
					<td>Item</td>

					<td>Price</td>
				</tr>
                @foreach($sale->saleDetails as $sale_detail)
				<tr class="item">
					<td>{{$sale_detail->menu_name}}</td>
					<td>{{$sale_detail->menu_price}}</td>
				</tr>
                @endforeach
                <hr>
				<tr class="total">
					<td></td>

					<td>
                        Total: <span>{{$sale->total_price}}</span>
                        <br />
                        <br />
                        Total Received: <span>{{$sale->total_received}}</span>
                        <br />
                        <br />
                        Total change:<span>{{$sale->change}}</span>
                    </td>
				</tr>
                <tr>
                    <td>
                        <a href="/cashier"><button class="btn back-button" role="button">Go Back</button></a>
                    </td>
                    <td>
                        <button class="btn" role="button" onclick="window.print();return false;">Print</button>
                    </td>
                </tr>
			</table>
		</div>
	</body>
</html>
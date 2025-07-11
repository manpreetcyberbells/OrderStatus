<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Order Status Checker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </head>
    <body class="bg-light py-5">
        <div class="container">
            <div class="row justify-content-center">
            <div class="col-md-6">

                <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Check Your Order Status</h5>
                </div>

                <div class="card-body">
                    <div class="mb-3">
                    <input type="text" id="order_number" class="form-control" placeholder="Enter your Order Number" />
                    </div>
                    <button id="check_status" class="btn btn-primary w-100">Check Status</button>
                </div>
                </div>
                <div id="order_status_result" class="mt-4"></div>
            </div>
            </div>
        </div>
        <script>
        $('#check_status').click(function() {
        const orderNumber = $('#order_number').val();
        const shop = "browns-staging.myshopify.com";

        if (!orderNumber) {
            alert('Please enter your order number');
            return;
        }

        $('#order_status_result').html(`
            <div class="text-center my-3">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            </div>
        `);

        $.ajax({
            url: '/order-status',
            method: 'GET',
            data: {
            action: 'order_status',
            order_number: orderNumber,
            shop: shop
            },
            success: function(response) {
            console.log('response', response);

            $('#order_status_result').html(`
                <div class="card border-success">
                <div class="card-header bg-success text-white">Order Status</div>
                <div class="card-body">
                    <p><strong>Order Number:</strong> ${response.order_number}</p>
                    <p><strong>Placed On:</strong> ${response.created_at}</p>
                    <p><strong>Message:</strong> ${response.status_message}</p>
                </div>
                </div>
            `);
            },
            error: function(xhr) {
            $('#order_status_result').html(`
                <div class="alert alert-danger" role="alert">
                Order not found or error occurred.
                </div>
            `);
            }
        });
        });
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>

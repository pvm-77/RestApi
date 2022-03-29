<!DOCTYPE html>
<html>
    <head>
        <title>How to Implement OTP SMS Mobile Verification in PHP with TextLocal</title>

        <link rel="stylesheet" href="<?= base_url('style/style.css') ?>">
    </head>
    <body>

        <div class="container">
            <div class="error"></div>
            <form id="frm-mobile-verification">
                <div class="form-heading">Mobile Number Verification</div>

                <div class="form-row">
                    <input type="number" id="mobile" class="form-input"
                           placeholder="Enter the 10 digit mobile">
                </div>

                <input type="button" class="btnSubmit" value="Send OTP" onClick="sendOTP();">
            </form>
        </div>
        <?//php $this->load->view('verficationMobile'); ?>
        <script src="<?= base_url('js/jquery-3.2.1.min.js') ?>" type="text/javascript"></script>
        <script>

                    function sendOTP() {
                        $(".error").html("").hide();
                        var number = $("#mobile").val();
                        if (number.length == 10 && number != null) {
                            var input = {
                                "mobile_number": number,
                                "action": "send_otp"
                            };
                            $.ajax({
                                url: '<?= base_url('Mobile_Otp/Mobile_number_otp'); ?>',
                                type: 'POST',
                                data: input,
                                success: function (response) {
                                    $(".container").html(response);
                                }
                            });
                        } else {
                            $(".error").html('Please enter a valid number!')
                            $(".error").show();
                        }
                    }

                    function verifyOTP() {
                        $(".error").html("").hide();
                        $(".success").html("").hide();
                        var otp = $("#mobileOtp").val();
                        var input = {
                            "otp": otp,
                            "action": "verify_otp"
                        };
                        if (otp.length == 6 && otp != null) {
                            $.ajax({
                                url: '<?= base_url('Mobile_Otp/Mobile_number_otp'); ?>',
                                type: 'POST',
                                dataType: "json",
                                data: input,
                                success: function (response) {
                                    $("." + response.type).html(response.message)
                                    $("." + response.type).show();
                                },
                                error: function () {
                                    alert("ss");
                                }
                            });
                        } else {
                            $(".error").html('You have entered wrong OTP.')
                            $(".error").show();
                        }
                    }

        </script>
    </body>
</html>
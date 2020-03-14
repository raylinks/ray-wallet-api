<?php $__env->startSection('content'); ?>

    <table width="100%" cellpadding="0" cellspacing="0"
           style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
        <tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
            <td class="content-block"
                style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top;
            background-color: #2D9CDB;
            text-align: center;
            border-radius: 10px;
            margin-left: 10%;
            margin-right: 10%;
            color: geeen;"
                valign="top">
                  Hi <b><?php echo e($email); ?></b>, Welcome to Raybaba site
                <h3 style="font-size:22px">Welcome to Raybaba.</h3>
            </td>
        </tr>
        <tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
            <td class="content-block"
                style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                valign="top">
                <br>
                
                
                <br>
                <br>
                We may need to send you critical information about our service and it is important that we have an accurate email address.

                <br>
                <p>Click on the button below to confirm your email address.</p>
            </td>
        </tr>
        <tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
            <td class="content-block"
                style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                valign="top">
                <center>
                    <a href="<?php echo e($email_link); ?>" class="btn-primary"
                       style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #5fbeaa; margin: 0; border-color: #5fbeaa; border-style: solid; border-width: 10px 20px;">Confirm Email Address</a>
                </center>

            </td>
        </tr>
        <tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
            <td class="content-block"
                style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px; float: right"
                valign="top">
                Patricia Admin.
            </td>
        </tr>
    </table>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('emails.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/raymond/Documents/my-works/ray-wallet-api/resources/views/emails/confirmMail.blade.php ENDPATH**/ ?>
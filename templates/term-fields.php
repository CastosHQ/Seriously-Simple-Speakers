<?php
/**
 * @since 1.0.3
 *
 * @var string $headshot
 * */
?>

<tr class="form-field">
    <th>
        <label for="ssp_headshot_url">Headshot</label>
    </th>
    <td>
        <img style="display: none" width="200" height="200" id="ssp_headshot_img" class="ssp-headshot-img" alt=""
             src="<?php echo esc_attr( $headshot ) ?>">
        <input type="text" name="ssp_speaker_headshot" id="ssp_headshot_url" class="ssp-headshot-url regular-text"
               value="<?php echo esc_attr( $headshot ) ?>">
        <input type="button" id="ssp_upload_headshot_btn" class="button-secondary" value="Upload Image">
        <input type="button" id="ssp_remove_headshot_btn" class="button-secondary" value="Remove Image">
    </td>
</tr>

<style>
    .ssp-headshot-img, .ssp-headshot-url {
        margin-bottom: 10px;
    }
</style>

<script type="text/javascript">
    jQuery(document).ready(function ($) {
        var $sspHeadshotUrl = $('#ssp_headshot_url'),
            $sspHeadshotImg = $('#ssp_headshot_img');

        if ($sspHeadshotUrl.val()) {
            $sspHeadshotImg.show();
        }

        $('#ssp_remove_headshot_btn').click(function () {
            $sspHeadshotImg.hide();
            $sspHeadshotUrl.val('');
        });

        $('#ssp_upload_headshot_btn').click(function (e) {
            e.preventDefault();
            var image = wp.media({
                title: 'Upload Image',
                multiple: false
            }).open()
                .on('select', function (e) {
                    var uploaded_image = image.state().get('selection').first(),
                        ssp_headshot_url = uploaded_image.toJSON().url;
                    $sspHeadshotUrl.val(ssp_headshot_url).trigger('change');
                });
        });

        $sspHeadshotUrl.on('change', function () {
            $sspHeadshotImg.prop('src', $sspHeadshotUrl.val()).show();
        });
    });
</script>

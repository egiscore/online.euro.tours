{foreach from=$elements item="item"}
    <fieldset id="fieldset_{$item.Alias}" class="fieldset_photo">
        <legend>{$item.Name}</legend>
        <div class="row">
            <table>
                <tr>
                    <td id="td_{$item.Alias}" class="td_photo" align="left">
                        <img id="{$item.Alias}_anketa" width="{$item.tpl_width}" height="{$item.tpl_height}" src="{$item.url_small}">
                    </td>
                    <td valign="top" class="photo_note">
                        {if $enable_save}
                            дл€ загрузки изображени€ вы можете использовать файлы в формате JPG, GIF, PNG<br>
                            <br>
                            параметры изображени€:<br>
                            минимальна€ ширина: {$item.Width} пикселей<br>
                            минимальна€ высота: {$item.Height} пикселей<br>
                            {if $item.Requirements}
                                <div class="doc-requirements req_{$item.Alias}">
                                    {$item.Requirements}
                                </div>
                            {/if}
                            <br>
                            <br>
                            <form method="POST" target="iframe_anketa_photo" name="form_anketa" id="form_anketa_{$item.Alias}" enctype="multipart/form-data" action="{$model.form_anketa_action}&samo_action=LOAD_RESIZE_PICTURE">
                                <input type=hidden name="PICTURE_TYPE" value="{$item.Alias}">
                                <div><input type="file" name="anketa_file" data-type="{$item.Alias}"></div>
                            </form>
                            <br><br>
                            <div id="div_crop_{$item.Alias}" style="display: none;">
                                ѕо€вилась область выделени€, которую вы можете двигать и измен€ть ее размер.<br>
                                <br>
                                ѕереместите область выделени€ на нужную часть картинки и нажмите кнопку "вырезать".<br>
                                <br>
                                <button class="crop_button" data-type="{$item.Alias}">¬ырезать</button>
                            </div>
                        {/if}
                    </td>
                </tr>
            </table>
        </div>
        <div class="anketa_hide"><br></div>
    </fieldset>
{/foreach}
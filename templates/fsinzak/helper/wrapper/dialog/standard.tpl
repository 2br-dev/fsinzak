{* Шаблон обертки диалогового окна *}
<div class="modal-dialog modal-dialog-centered layout-modal {block "class"}{/block}" {block name="attributes"}{/block}>
    <div class="modal-content">
        <button type="button" class="btn-close modal-close" data-bs-dismiss="modal" aria-label="Close">
{*            <img src="{$THEME_IMG}/icons/close.svg" width="24" height="24" alt="">*}
        </button>
{*        <div class="row">*}
            <div class="modal-header col s12">
                <h3 class="modal-title">{block "title"}{/block}</h3>
            </div>
            <div class="modal-body">{block "body"}{/block}</div>
            {block "footer"}{/block}
{*        </div>*}
    </div>
</div>

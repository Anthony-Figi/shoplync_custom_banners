<div id="{if isset($banner_id)}{$banner_id}{else}default{/if}-html-banner">
{if $banner_content}
    {$banner_content|html}
{else}
    <p>No content available</p>
{/if}
</div>
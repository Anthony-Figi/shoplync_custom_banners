<div id="{if isset($banner_id)}{$banner_id}{else}default{/if}-text-banner">
{if $banner_content}
    <h1>{$banner_content}</h1>
{else}
    <p>No content available</p>
{/if}
</div>
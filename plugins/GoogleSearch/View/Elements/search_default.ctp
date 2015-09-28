<div id="cse-search-form">
<?php echo $this->Form->create('Search',array('url' => Router::url(array('controller' => 'searches', 'action' => 'index','plugin'=>'search'),true), 'class'=>'gsc-search-box')); ?>
<table cellspacing="0" cellpadding="0" class="gsc-search-box">
<tbody>
<tr>
    <td class="gsc-input">
    <?php echo $this->Form->input('query',array('label'=>'','autocomplete'=>'off','class'=>'gsc-input', 'title'=>'wyszukaj','div'=>false)); ?>
    </td>
    <td class="gsc-search-button">
        <?php echo $this->Form->submit(__d('public','Wyszukaj'),array('class'=>'gsc-search-button','title'=>'wyszukaj')); ?>
    </td>
    <td class="gsc-clear-button">
        <div class="gsc-clear-button" title="wyczyœæ wyniki">&nbsp;</div>
    </td>
</tr>
</tbody>
</table>
<table cellspacing="0" cellpadding="0" class="gsc-branding">
<tbody>
    <tr>
        <td class="gsc-branding-user-defined"></td>
        <td class="gsc-branding-text"><div class="gsc-branding-text">Technologia</div></td>
        <td class="gsc-branding-img"><img src="http://www.google.com/uds/css/small-logo.png" class="gsc-branding-img" /></td>
    </tr>
</tbody>
</table>
<?php echo $this->Form->end(); ?> 
</div>
<script type="text/javascript">
var InputSearch = $('.gsc-input:first input:first');
var InputBackground = 'url("http://www.google.com/coop/intl/pl/images/google_custom_search_watermark.gif") no-repeat scroll left center #FFFFFF';
InputSearch.css('background', InputBackground);

InputSearch.blur(function() {
   if(!$(this).val()){
        $(this).css('background', InputBackground);
    }
});
InputSearch.focus(function() {
  $(this).css('background', 'white');
});
</script>
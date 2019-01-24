<form id="dealer-id" action='' method='get'>
    <input type='text' name='code' id='code' placeholder='Enter a Dealer code..' />
    <input type="button" class='small-button' id='dealerCode'>
</form>

<script type="text/javascript">
	  $( document ).ready(function() {
        $('#dealerCode').click(function(){
            var code = encodeURI($('#code').val());
            parent.location = 'proofing.accunityservices.com/digitalsignature/public/en/placeorder' + code;
        });
});
</script>

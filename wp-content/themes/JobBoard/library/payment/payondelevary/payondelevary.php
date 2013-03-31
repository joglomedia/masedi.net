<?php /*?><table>
<tr><td><input type="radio" name="paymentmethod" id="paydeltype1" value="cash" checked="checked" /></td><td>Cash Payment</td></tr>
<tr><td><input type="radio" name="paymentmethod" id="paydeltype2" value="cheque" /></td><td>Cheque/DD Payment</td></tr>
<tr><td colspan="2">
<table>
<tr><td>Cheque/DD Number : </td><td><input type="text" name="chequenumber" id="chequenumber" /></td></tr>
<tr><td>Bank Detail : </td><td><input type="text" name="bankdetail" id="bankdetail"  /></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
</table></td></tr>
</table>
<script>

$(function(){
	
	document.getElementById('payondelevary').innerHTML = '';
	var chq = document.getElementById('chequenumber').value;
	var bank = document.getElementById('bankdetail').value;
	document.getElementById('chequenumber').value = chq.trim();
	document.getElementById('bankdetail').value = bank.trim();
	
	$("#checkout_frm").submit(function(){
		if(document.getElementById('paydeltype2').checked)
		{
			if(chq.trim() == '')
			{
				alert('Please enter Cheque/DD Number');
				document.getElementById('chequenumber').focus();
				return false;
			}
			if(bank.trim() == '')
			{
				alert('Please enter Bank Detail');
				document.getElementById('bankdetail').focus();
				return false;
			}
		}
		return true;
	});
});
</script><?php */?>
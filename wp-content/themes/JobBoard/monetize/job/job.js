function myfields(fid)
{
	document.getElementById(fid+'_hidden').value = document.getElementById(fid).value;
}

function featured_list(fid)
{
	if((document.getElementById('featured_h').checked== true) && (document.getElementById('featured_c').checked== true))
	{
		document.getElementById('featured_type').value = 'both';
		document.getElementById('feture_price').innerHTML = parseFloat(document.getElementById('featured_c').value) + parseFloat(document.getElementById('featured_h').value);
		document.getElementById('result_price').innerHTML = parseFloat(document.getElementById('featured_c').value) + parseFloat(document.getElementById('featured_h').value) +  parseFloat(document.getElementById('pkg_price').innerHTML);
		
		document.getElementById('total_price').value = parseFloat(document.getElementById('featured_c').value) + parseFloat(document.getElementById('featured_h').value) +  parseFloat(document.getElementById('pkg_price').innerHTML);
	
	}else if((document.getElementById('featured_h').checked == true) && (document.getElementById('featured_c').checked == false)){
		document.getElementById('featured_type').value = 'h';
		document.getElementById('feture_price').innerHTML = document.getElementById('featured_h').value;
		
		document.getElementById('result_price').innerHTML = parseFloat(document.getElementById('featured_h').value) +  parseFloat(document.getElementById('pkg_price').innerHTML);
		
		document.getElementById('total_price').value = parseFloat(document.getElementById('featured_h').value) +  parseFloat(document.getElementById('pkg_price').innerHTML);
	}else if((document.getElementById('featured_h').checked == false) && (document.getElementById('featured_c').checked == true)){
		document.getElementById('featured_type').value = 'c';
		document.getElementById('feture_price').innerHTML = document.getElementById('featured_c').value;
		
		document.getElementById('result_price').innerHTML = parseFloat(document.getElementById('featured_c').value) +  parseFloat(document.getElementById('pkg_price').innerHTML);
		
		document.getElementById('total_price').value = parseFloat(document.getElementById('featured_c').value) +  parseFloat(document.getElementById('pkg_price').innerHTML);
		
	}else if((document.getElementById('featured_h').checked == false) && (document.getElementById('featured_c').checked == false)){
		document.getElementById('featured_type').value = 'none';
		document.getElementById('feture_price').innerHTML = '0';
		document.getElementById('result_price').innerHTML = parseFloat(document.getElementById('pkg_price').innerHTML);
		
		document.getElementById('total_price').value = parseFloat(document.getElementById('pkg_price').innerHTML);
	
	}else{
		document.getElementById('featured_type').value = 'none';
		document.getElementById('feture_price').innerHTML = '0';
		document.getElementById('result_price').innerHTML = parseFloat(document.getElementById('pkg_price').innerHTML);
		
		document.getElementById('total_price').value = parseFloat(document.getElementById('pkg_price').innerHTML);
	}
}

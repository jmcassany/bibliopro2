	function launchPreview(address) {
		void(window.open(address,'preview','height=1280,width=1024,resizable=yes,scrollbars=yes'));
		return false;
	}

	function checkDeleteList(campaignID,ListID,Count) {	
		var msg = "Esteu segurs que voleu anul·lar del butlletí l’enviament cap a aquesta llista de " + Count + " subscriptors?";
		if (confirm(msg))
			location.replace("resum.php?IdCam=" + campaignID + "&llista=" + ListID + "&accio=eliminadesti");			
		return false;
	}
	function toggleLayer( whichLayer )
{
 var elem, vis;
  if( document.getElementById ) // this is the way the standards work
    elem = document.getElementById( whichLayer );
  else if( document.all ) // this is the way old msie versions work
      elem = document.all[whichLayer];
  else if( document.layers ) // this is the way nn4 works
    elem = document.layers[whichLayer];
  vis = elem.style;
  // if the style.display value is blank we try to figure it out here
  if(vis.display==''&&elem.offsetWidth!=undefined&&elem.offsetHeight!=undefined)
    vis.display = (elem.offsetWidth!=0&&elem.offsetHeight!=0)?'block':'none';
  vis.display = (vis.display==''||vis.display=='block')?'none':'block';
}

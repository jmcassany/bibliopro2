function obrir(nom,amplada,baixada){
  pitekandemor="left=0,top=0,screenX=0,screenY=0,status=no,toolbar=no,width="+amplada+",height="+baixada+",directory=no,resize=no,scrollbars=yes";
  result = window.open(nom,"",pitekandemor);
}

function missatge(nom){
  pitekandemor="left=0,top=0,screenX=0,screenY=0,status=no,toolbar=no,width=200,height=200,directory=no,resize=no,scrollbars=no";
  result = window.open(nom,"missatge",pitekandemor);
}

function carregat(){
  document.getElementById('carregant').style.display='none';
  document.getElementById('contingut').style.display='inline';
}

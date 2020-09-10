/* fa que tots els links marcats com a rel="extenal"
sobrin en una pàgina blanca */
function externalLinks() {
  $('a[@rel=external]').attr('target', '_blank');
}
$(document).ready(externalLinks);

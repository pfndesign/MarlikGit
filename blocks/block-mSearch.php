<?php
if (eregi("block-mSearch.php", $_SERVER['PHP_SELF'])) {
    Header("Location: index.php");
    die();
}
$content = '<form method="post" action="modules.php"><table border="0" width="100%"><tr><td>
<input type="text" name="query" style="width:100%" /></td><td>
<input type="hidden" name="name" value="mSearch" />
<input type="hidden" name="what" value="all" />
<input type="hidden" name="op" value="gsearch" />
<input type="submit" value="' . _GO . '" /></td></tr></table></form>';
?>

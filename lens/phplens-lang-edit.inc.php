<?php
class PHPLensEditLang {
// menu
var $backToGrid = "Back to Grid";
var $tableSettings = "phpLens Settings";
var $columnSettings = "Column Settings";
var $removeAll = "Remove&nbsp;All&nbsp;Settings";
var $confirmReset = 'This will remove all settings permanently. Are you sure?\n\nMake sure you have Generated PHP Code first.';
var $choose = "Choose";
var $generateCode = "Generate&nbsp;PHP&nbsp;Code";
var $saveCode = "Save&nbsp;PHP&nbsp;Code";
var $fileSaved = " file saved";
var $fileNotSaved = " file save error";
var $fileNotBackedUp = " file not backed up";
var $logout = 'Logout';

var $badPowerLensChar = "%s is an illegal for %s. Reserved as seperator character.\n";
	// select columns	
var $editgrid =     "Grid Columns";
var $editdetail=    "Detail Columns";
var $editedit=      "Edit Columns";	
var $editnew=       "New Record Columns";
var $editreadonly=  "Read Only Columns";
var $editfilter=    "Filter/Search Columns";
var $editmustfill=  "Must Fill Columns";
var $editsum =      "Columns to Sum";
var $edittextarea = "Text Area Columns";

var $menusHide = 'Hide Menus';
var $menuHideAll = 'Hide Top and Bottom Menu';
var $menuHideTop = 'Hide Top Menu';
var $menuHideBottom = 'Hide Bottom Menu';
var $menuHideScroll = 'Hide Scrolling';
var $menuHideEnd = 'Hide Scroll to End';
var $menuHideFilter = 'Hide Filter/Search';

var $multiUser = '<font color=red><b>Multiuser warning</b></font>: this phpLens object was modified %d seconds ago by another browser located at %s';

var $templateInUse = 'Templates are in use, so column selections must match templates exactly to display correctly<br>';
var $editgrid2 =     "<h3>Select Grid Columns &nbsp; (<i>left</i>=hide cols, <i>right</i>=show cols)</h3>";
var $editdetail2=    "<h3>Select Detail Columns &nbsp; (<i>left</i>=hide cols, <i>right</i>=show cols)</h3>";
var $editedit2=      "<h3>Select Edit Columns &nbsp; (<i>left</i>=hide cols, <i>right</i>=show cols)</h3>";	
var $editnew2=       "<h3>Select New Record Columns &nbsp; (<i>left</i>=hide cols, <i>right</i>=show cols)</h3>";
var $editreadonly2=  "<h3>Select Read Only Columns &nbsp; (<i>left</i>=editable cols, <i>right</i>=read only cols)</h3>";
var $editfilter2=    "<h3>Select Filter/Search Columns &nbsp; (<i>left</i>=hide cols, <i>right</i>=show cols)</h3>";
var $editmustfill2=  "<h3>Select Must Fill Columns &nbsp; (<i>left</i>=normal cols, <i>right</i>=must fill cols)</h3>";
var $editsum2 =      "<h3>Select Columns to Sum &nbsp; (<i>left</i>=normal cols, <i>right</i>=sum cols)</h3>";
var $edittextarea2 = "<h3>Select Text Area Columns &nbsp; (<i>left</i>=normal cols, <i>right</i>=textarea cols)</h3>";
	// colors
var $colorSettings = "<b>Color Settings</b>";
var $saveColors = 'Save Colors';
var $topCaption =  "Top Caption"; 
var $menuBackground = "Menu Background";
var $menuColor = "Menu Color";
var $titleBackground = "Title Background";
var $oddRows = "Odd Rows";
var $evenRows = "Even Rows";
var $currentRow = "Current Row";
var $rowNumberBackground = "Row Number Background";
var $group = "Group";
var $subTotal = "Subtotal";
var $total = "Total";
var $bottomCaption = "Bottom Caption";
var $selectColorStyle = "<font color=darkred><b>Select Color Style:</b></font> &nbsp;";

var $detailTable = "Detail Table";
var $leftDetail = "Detail Left Column";
var $rightDetail = "Detail Right Column";
var $background = "Background";

var $colorRef = "Color Reference";
var $opensNewWin = " opens in a new window";

// global Table settings
var $saveLens = 'Save phpLens Settings';
var $showBtn1 = "Enable this feature and show "; // make sure included space at end
var $showBtn2 = " button";
var $requiresTableColSet = "Requires <i>Data Save Table </i>and <i>Primary Key</i> to be set";

var $firstState = 'Start phpLens';
var $stateVIEW = 'View Grid';
var $stateEDIT = 'Edit Record (set property redirectOnUpdate also)';
var $stateNEW = 'New Record (set property redirectOnInsert also)';
var $stateFILTER = 'Search Form';

var $sql = "SQL";
var $listTables = "<font size=2>List Tables</font>";

var $rowsPerPage = '#Rows per Page';
var $groupBy = 'Group by Field';
var $groupBy2 = " &nbsp; Group rows by this database field";
var $recHide = "Hide Record Number and Detail Table";
var $recLeft = 'Left';
var $recRight = 'Right';
var $showRecNo = 'Show Details &amp; RecNo';
var $showRecHideDetails = "Show Record Number and Hide Details";

var $canNew = 'Allow New Record Creation';
var $canEdit = 'Allow Record Editing';
var $canDelete = 'Allow Record Deletes';
var $canChild = 'Child Editor in Detail Grid';
var $childNew = 'Create and Edit records in detail grid';
var $childEdit = 'Edit records in detail grid';

var $dataColumns = 'Columns:';
var $dataSaveTable = 'Data Save Table';
var $dataPrimaryKey = 'Primary Key';
var $allowSorting = 'Allow Sorting';
var $showHeaders = 'Show Column Headers';
var $displayDate = 'Display Date';
var $inputDate = 'Input Date';
var $displayTS = 'Display Timestamp';
var $inputTS = 'Input Timestamp';
var $debug = 'Debug';

// cols
var $type = 'Type';
var $gridTitle = 'Grid&nbsp;Title';
var $detailTitle = "Detail&nbsp;Title";
var $editTitle = "Edit&nbsp;Title";
var $newTitle = "New&nbsp;Title";
		
var $powerLens = 'Power Lens';
var $validation = 'Validation';
var $valid1 = "<pre> X: 0-9 A-Z             x: 0-9 A-Z optional<br>";
var $valid2 = " #: 0-9                 9: 0-9 optional           +: positive numbers only<br>";
var $valid3 = " &: any character       ?: any character optional \\: escape character\n";
var $valid4 = " >: to uppercase        <: to lowercase</pre>";
var $validationErrorMsg = 'Validation Error Msg';
var $defaultValue = 'Default New Value';
var $defaultNote = "<br><font size=-1>Prefix value with = to execute PHP code and % for SQL function</font>";
var $editPowerLens = 'Edit Power Lens';
var $inputType = "Input Type";
var $checkbox = 'Use Check Boxes';
var $radio = 'Radio Buttons';
var $submit = 'Submit Buttons';
var $normalInput = 'Text or Popup';
var $multipleInput = 'Multiple Select';

var $columnBackgroundColor = 'Cell Color';

var $noEncoding = "No Encoding";
var $colIsNativeHTML = 'This Field supports Double-Byte (eg Chinese, Japanese) and HTML tags';
var $mustFill = 'Must Fill';
var $readonly = 'Read Only';
var $visibleInGrid = "Visible in Grid";
var $visibleInDetails = "Visible in Details";
var $visibleInNew = "Visible in New Record";
var $visibleInEdit = "Visible in Edit Record";

// charting
var $charting = '<b>Charting</b>';
var $width = 'Width';
var $height = 'Height';
var $chartDimensions = 'Chart Dimensions';
var $chartMinMaxManual = 'Chart Min/Max (manual)';
var $chartMinMaxSQL = 'Chart Min/Max (SQL)';
var $chartSQLMinMax = 'SQL to get Min/Max field values';
var $chartMin = 'Minimum field value';
var $chartMax = 'Maximum field value';
var $scale = 'Icon Chart Scale';
var $chartImage = 'Chart Images';
var $chartImage2 = 'GIF/JPEG file';
var $negativeChart = 'Image for negative values (only for bar chart)';
// filter
var $column = 'Column';
var $title = 'Title';
var $lookup = 'Lookup Values';
var $filterOptions = 'Filter Options';
var $filterTxt1 = '<BR>To generate a popup use:<BR> (1) <i>SELECT distinct COL FROM TABLE</i> to list choices.<BR>';
var $filterTxt2 = '(2) Enter a list of the form (must begin with=): <i>=No';
var $filterTxt3 = 'Yes</i>';
var $useCheckboxes = 'Use Checkboxes';
var $numCheckboxCols = '# Checkbox Columns';	

// editing visible cols
var $up = 'Up';
var $down = 'Down';
var $left = '<b>&lt;&lt;</b>';
var $right = '<b>>></b>';
};

?>
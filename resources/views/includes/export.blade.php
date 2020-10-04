

<li><a class="btn bg-blue-grey waves-effect" onClick ="print_content('{{$exportId}}');" ><i class="fa fa-print"></i>Print</a></li>
<li><a class="btn bg-red waves-effect" onClick ="print_content('{{$exportId}}');" ><i class="fa fa-file-pdf-o"></i>Pdf</a></li>
<li><a class="btn bg-light-green" onClick ="$('#{{$exportId}}').tableExport({type:'excel',escape:'false'});" ><i class="fa fa-file-excel-o"></i>Excel</a></li>
<li><a class="btn btn-primary" onClick ="exportDoc('{{$exportDocId}}');" ><i class="fa fa-file-word-o"></i>Msword</a></li>


<?php //pr($salesInvoice); exit;
/**
 * @Author: PHP Poets IT Solutions Pvt. Ltd.
 */
$this->set('title', 'Sales Return');
foreach($partyOptions as $partyOption)
{
		$value=$partyOption['value'];
	if($value==$salesInvoice->party_ledger_id)
	{
		$party_states=$partyOption['party_state_id'];
	if($party_states>'0')
	{
		$party_state_id=$party_states;
	}
	else
	{
		$party_state_id=$state_id;
	}
	}
}
?>

<div class="row">
	<div class="col-md-12">
		<div class="portlet light ">
			<div class="portlet-title">
				<div class="caption">
					<i class="icon-bar-chart font-green-sharp hide"></i>
					<span class="caption-subject font-green-sharp bold ">Sales Return</span>
				</div>
			</div>
			<div class="portlet-body">
				<?= $this->Form->create($salesInvoice,['onsubmit'=>'return checkValidation()']) ?>
					<div class="row">
						<div class="col-md-2">
							<div class="form-group">
								<label><b>Voucher No :</b></label>&nbsp;&nbsp;<br>
								<?= h('#'.str_pad($salesInvoice->voucher_no, 4, '0', STR_PAD_LEFT)) ?>
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<label><b>Transaction Date</b></label><br>
								<?php echo $this->Form->control('transaction_date',['type'=>'hidden','data-date-format'=>'dd-mm-yyyy','label'=>false,'placeholder'=>'DD-MM-YYYY','data-date-start-date'=>@$coreVariable[fyValidFrom],'data-date-end-date'=>@$coreVariable[fyValidTo],'value'=>$salesInvoice->transaction_date, 'autofocus'=>'autofocus']); 
								echo $salesInvoice->transaction_date;
								?>
							</div>
						</div>
						<input type="hidden" name="party_state_id" class="ps" value="<?php echo $party_state_id;?>">
                        <input type="hidden" name="outOfStock" class="outOfStock" value="false">
						
						<input type="hidden" name="company_id" class="company_id" value="<?php echo $company_id;?>">
						<input type="hidden" name="location_id" class="location_id" value="<?php echo $location_id;?>">
						<input type="hidden" name="state_id" class="state_id" value="<?php echo $state_id;?>">
						<input type="hidden" name="is_interstate" id="is_interstate" value="<?php if(@$party_state_id!=$state_id){if($party_state_id>0){echo '1';}
									else if($party_state_id==0){echo '0';}else if(!$party_state_id){echo '0';}
									}else if(@$party_state_id==$state_id) { echo '0';}
									?>">
						<input type="hidden" name="isRoundofType" id="isRoundofType" class="isRoundofType" value="0">
						<input type="hidden" name="voucher_no" id="" value="<?=$salesInvoice->voucher_no?>">
						<div class="col-md-3">
								<label><b>Party</b></label><br/>
								<?php echo $this->Form->control('party_ledger_id',['type'=>'hidden',  'value'=>$salesInvoice->party_ledger_id]);
								 echo $salesInvoice->party_ledger->name;
								?>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label><b>Sales Account</b></label>
								<?php echo $this->Form->control('sales_ledger_id',['class'=>'form-control input-sm sales_ledger_id select2me','label'=>false, 'options' => $Accountledgers,'required'=>'required', 'value'=>$salesInvoice->sales_ledger_id]);
								?>
							</div>
						</div> 
						<div class="col-md-2">
							<div class="form-group">
								<label><b>Transaction Date</b></label><br>
								<?php echo $this->Form->control('transaction_date',['type'=>'text','class'=>'form-control input-sm date-picker','data-date-format'=>'dd-mm-yyyy','label'=>false,'placeholder'=>'DD-MM-YYYY','data-date-start-date'=>@$coreVariable[fyValidFrom],'data-date-end-date'=>@$coreVariable[fyValidTo], 'autofocus'=>'autofocus']); 
								
								?>
							</div>
						</div>
					</div>
					<br>
				   <div class="row">
					<div class="col-md-10"><b>Sales Invoice</b></div>
					<div class="col-md-2"><b>Sales Return</b></div>
				   </div>
				   <div class="row"></div>
				   <div class="row">
				  <div class="table-responsive">
								<table id="main_table" class="table table-condensed table-bordered" style="margin-bottom: 4px;" width="100%">
								<thead>
								<tr align="center">
									<td ><label>Item<label></td>
									<td ><label>Qty<label></td>
									<td><label>Rate<label></td>
									<td><label>Discount(%)<label></td>
									<td><label>Taxable Value<label></td>
									
									<td><label id="gstDisplay">
										<?php if(@$party_state_id!=$state_id){if($party_state_id>0){echo 'IGST';}
										else if($party_state_id==0){echo 'GST';}else if(!$party_state_id){echo 'GST';}
										}else if(@$party_state_id==$state_id) { echo 'GST';}
										?>
									<label></td>
									<td><label>Net Amount<label></td>
									<td><label>Return Quantity<label></td>
									<td></td>
								</tr>
								</thead>
								<tbody id='main_tbody' class="tab">
								 <?php if(!empty($salesInvoice->sales_invoice_rows))
                                         $i=0;		
								         foreach($salesInvoice->sales_invoice_rows as $salesInvoiceRow)
									     {
										 
									if(@$party_state_id!=$state_id){if($party_state_id>0){ $exactgst=$salesInvoiceRow->gst_value;}
									else if($party_state_id==0){$exactgst=$salesInvoiceRow->gst_value/2;}else if(!$party_state_id){$exactgst=$salesInvoiceRow->gst_value/2;}
									}else if(@$party_state_id==$state_id) { $exactgst=$salesInvoiceRow->gst_value/2;}
							     ?>
								<tr class="main_tr" class="tab">
									<td width="20%">
										<input type="hidden" name="salesInvoiceRow<?php echo $i;?>id" class="id" value="<?php echo $salesInvoiceRow->id; ?>">
										<input type="hidden" name="" class="outStock" value="0">
										<input type="hidden" name="" class="totStock " value="0">
										<input type="hidden" name="" class="exactQty " value="<?php echo $salesInvoiceRow->quantity;?>">
										<input type="hidden" name="gst_amount" class="gst_amount" value="">	
										<input type="hidden" name="salesInvoiceRow<?php echo $i;?>gst_figure_id" class="gst_figure_id" value="<?php echo $salesInvoiceRow->gst_figure_id;?>">
										<input type="hidden" name="" class="gst_figure_tax_percentage calculation" value="<?php echo $salesInvoiceRow->gst_figure->tax_percentage;?>">
										<input type="hidden" name="" class="totamount calculation" value="">
										<input type="hidden" name="salesInvoiceRow<?php echo $i;?>gst_value" class="gstValue calculation" value="<?php echo $salesInvoiceRow->gst_value;?>">
										<input type="hidden" name="exactgst_value" class="exactgst_value calculation" value="<?php $exactgst;?>">
										<input type="hidden" name="" class="discountvalue calculation" value="">
											
										<?php echo $this->Form->input('q', ['type'=>'hidden','empty'=>'-Item Name-','label' => false,'class' => 'form-control input-sm attrGet calculation','required'=>'required','value'=>$salesInvoiceRow->item->id]);
										echo $salesInvoiceRow->item->name;
										echo $this->Form->input('q', ['value'=>$salesInvoiceRow->id,'type'=>'hidden']);
										?>
										<span class="itemQty" style="color:red"></span>
								</td>
								<td width="5%">
									<?php echo $this->Form->input('q', ['type'=>'hidden','label' => false,'class' => 'form-control input-sm calculation quantity rightAligntextClass','id'=>'check','disabled','required'=>'required','placeholder'=>'Quantity', 'value'=>$salesInvoiceRow->quantity-@$sales_return_qty
									[@$salesInvoiceRow->item->id]]); 
									echo $salesInvoiceRow->quantity-@$sales_return_qty
									[@$salesInvoiceRow->item->id];
									
									?>
								</td>
								<td width="5%">
									<?php echo $this->Form->input('q', ['type'=>'hidden','label' => false,'class' => 'form-control input-sm calculation rate rightAligntextClass','required'=>'required','placeholder'=>'Rate','value'=>$salesInvoiceRow->rate, 'readonly'=>'readonly', 'tabindex'=>'-1']);
									echo $salesInvoiceRow->rate;
									?>
								</td>
								<td>
									<?php echo $this->Form->input('q', ['type'=>'hidden','label' => false,'class' => 'form-control input-sm calculation discount rightAligntextClass','placeholder'=>'Dis.','disabled', 'value'=>$salesInvoiceRow->discount_percentage]); 
									echo $salesInvoiceRow->discount_percentage;
									?>	
								</td>
								<td>
								<?php echo $this->Form->input('q', ['label' => false,'class' => 'form-control input-sm gstAmount reverse_total_amount rightAligntextClass','required'=>'required', 'placeholder'=>'Amount', 'value'=>$salesInvoiceRow->taxable_value, 'readonly'=>'readonly', 'tabindex'=>'-1']); ?>	
								</td>
								<td>
									<?php echo $this->Form->input('q', ['label' => false,'class' => 'form-control input-sm gst_figure_tax_name rightAligntextClass', 'readonly'=>'readonly','required'=>'required','placeholder'=>'', 'value'=> $salesInvoiceRow->gst_figure->name, 'tabindex'=>'-1']); ?>	
								</td>
								<td>
									<?php echo $this->Form->input('q', ['label' => false,'class' => 'form-control input-sm discountAmount calculation rightAligntextClass','required'=>'required', 'readonly'=>'readonly','placeholder'=>'Taxable Value', 'value'=>$salesInvoiceRow->net_amount, 'tabindex'=>'-1']); ?>	
								</td>

								<td>
									<?php echo $this->Form->input('q', ['label' => false,'class' => 'form-control input-sm returnQty calculation rightAligntextClass','placeholder'=>'Return Quantity',  'tabindex'=>'-1','type'=>'number']); ?>	
								</td>
															
								<td align="center">
								<?php if($salesInvoiceRow->quantity-@$sales_return_qty
									[@$salesInvoiceRow->item->id] > 0){ ?>
									<label><?php echo $this->Form->input('check', ['label' => false,'type'=>'checkbox','class'=>'rename_check','value' => @$salesInvoiceRow->item->id]); ?></label>
									<?php  } ?>
								</td>
							</tr>
								<?php $i++; } ?>
								</tbody>
								<tfoot>
									
						<tr>
						<td colspan="7" align="right"><b>Amt Before Tax</b>
						</td>
						<td colspan="2">
						<?php echo $this->Form->input('amount_before_tax', ['label' => false,'class' => 'form-control input-sm amount_before_tax rightAligntextClass','required'=>'required', 'readonly'=>'readonly','placeholder'=>'', 'tabindex'=>'-1']); ?>	
						</td>
						</tr>
						
						<tr id="add_cgst">
						<td colspan="7" align="right"><b>Total CGST</b>
						</td>
						<td colspan="2">
						<?php echo $this->Form->input('total_cgst', ['label' => false,'class' => 'form-control input-sm add_cgst rightAligntextClass','required'=>'required', 'readonly'=>'readonly','placeholder'=>'', 'tabindex'=>'-1']); ?>	
						</td>
						</tr>
						<tr id="add_sgst">
						<td colspan="7" align="right"><b>Total SGST</b>
						</td>
						<td colspan="2">
						<?php echo $this->Form->input('total_sgst', ['label' => false,'class' => 'form-control input-sm add_sgst rightAligntextClass','required'=>'required', 'readonly'=>'readonly','placeholder'=>'', 'tabindex'=>'-1']); ?>	
						</td>
						</tr>
						<tr id="add_igst" style="">
						<td colspan="7" align="right"><b>Total IGST</b>
						</td>
						<td colspan="2">
						<?php echo $this->Form->input('total_igst', ['label' => false,'class' => 'form-control input-sm add_igst rightAligntextClass','required'=>'required', 'readonly'=>'readonly','placeholder'=>'', 'tabindex'=>'-1']); ?>	
						</td>
						</tr>
				
						<tr>
						<td colspan="7" align="right"><b>Round OFF</b>
						</td>
						<td colspan="2">
						<?php echo $this->Form->input('round_off', ['label' => false,'class' => 'form-control input-sm roundValue rightAligntextClass','required'=>'required', 'readonly'=>'readonly','placeholder'=>'', 'tabindex'=>'-1']); ?>	
						</td>
						</tr>
									
						<tr>
						<td colspan="7" align="right"><b>Amt After Tax</b>
						</td>
						<td colspan="2">
						<?php echo $this->Form->input('amount_after_tax', ['label' => false,'class' => 'form-control input-sm amount_after_tax rightAligntextClass','required'=>'required', 'readonly'=>'readonly','placeholder'=>'', 'tabindex'=>'-1']); ?>	
						</td>
						</tr>
					</tfoot>
					</table>
				   </div>
				  </div>
			</div>
				<?= $this->Form->button(__('Submit'),['class'=>'btn btn-success submit']) ?>
				<?= $this->Form->end() ?>
		</div>
	</div>
</div>

<!-- BEGIN PAGE LEVEL STYLES -->
	<!-- BEGIN COMPONENTS PICKERS -->
	<?php echo $this->Html->css('/assets/global/plugins/clockface/css/clockface.css', ['block' => 'PAGE_LEVEL_CSS']); ?>
	<?php echo $this->Html->css('/assets/global/plugins/bootstrap-datepicker/css/datepicker3.css', ['block' => 'PAGE_LEVEL_CSS']); ?>
	<?php echo $this->Html->css('/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css', ['block' => 'PAGE_LEVEL_CSS']); ?>
	<?php echo $this->Html->css('/assets/global/plugins/bootstrap-colorpicker/css/colorpicker.css', ['block' => 'PAGE_LEVEL_CSS']); ?>
	<?php echo $this->Html->css('/assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css', ['block' => 'PAGE_LEVEL_CSS']); ?>
	<?php echo $this->Html->css('/assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css', ['block' => 'PAGE_LEVEL_CSS']); ?>
	<!-- END COMPONENTS PICKERS -->

	<!-- BEGIN COMPONENTS DROPDOWNS -->
	<?php echo $this->Html->css('/assets/global/plugins/bootstrap-select/bootstrap-select.min.css', ['block' => 'PAGE_LEVEL_CSS']); ?>
	<?php echo $this->Html->css('/assets/global/plugins/select2/select2.css', ['block' => 'PAGE_LEVEL_CSS']); ?>
	<?php echo $this->Html->css('/assets/global/plugins/jquery-multi-select/css/multi-select.css', ['block' => 'PAGE_LEVEL_CSS']); ?>
	<!-- END COMPONENTS DROPDOWNS -->
<!-- END PAGE LEVEL STYLES -->

<!-- BEGIN PAGE LEVEL PLUGINS -->
	<!-- BEGIN COMPONENTS PICKERS -->
	<?php echo $this->Html->script('/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js', ['block' => 'PAGE_LEVEL_PLUGINS_JS']); ?>
	<?php echo $this->Html->script('/assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js', ['block' => 'PAGE_LEVEL_PLUGINS_JS']); ?>
	<?php echo $this->Html->script('/assets/global/plugins/clockface/js/clockface.js', ['block' => 'PAGE_LEVEL_PLUGINS_JS']); ?>
	<?php echo $this->Html->script('/assets/global/plugins/bootstrap-daterangepicker/moment.min.js', ['block' => 'PAGE_LEVEL_PLUGINS_JS']); ?>
	<?php echo $this->Html->script('/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js', ['block' => 'PAGE_LEVEL_PLUGINS_JS']); ?>
	<?php echo $this->Html->script('/assets/global/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js', ['block' => 'PAGE_LEVEL_PLUGINS_JS']); ?>
	<?php echo $this->Html->script('/assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js', ['block' => 'PAGE_LEVEL_PLUGINS_JS']); ?>
	<!-- END COMPONENTS PICKERS -->
	
	<!-- BEGIN COMPONENTS DROPDOWNS -->
	<?php echo $this->Html->script('/assets/global/plugins/bootstrap-select/bootstrap-select.min.js', ['block' => 'PAGE_LEVEL_PLUGINS_JS']); ?>
	<?php echo $this->Html->script('/assets/global/plugins/select2/select2.min.js', ['block' => 'PAGE_LEVEL_PLUGINS_JS']); ?>
	<?php echo $this->Html->script('/assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js', ['block' => 'PAGE_LEVEL_PLUGINS_JS']); ?>
	<!-- END COMPONENTS DROPDOWNS -->
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
	<!-- BEGIN COMPONENTS PICKERS -->
	<?php echo $this->Html->script('/assets/admin/pages/scripts/components-pickers.js', ['block' => 'PAGE_LEVEL_SCRIPTS_JS']); ?>
	<!-- END COMPONENTS PICKERS -->

	<!-- BEGIN COMPONENTS DROPDOWNS -->
	<?php echo $this->Html->script('/assets/global/scripts/metronic.js', ['block' => 'PAGE_LEVEL_SCRIPTS_JS']); ?>
	<?php echo $this->Html->script('/assets/admin/layout/scripts/layout.js', ['block' => 'PAGE_LEVEL_SCRIPTS_JS']); ?>
	<?php echo $this->Html->script('/assets/admin/layout/scripts/quick-sidebar.js', ['block' => 'PAGE_LEVEL_SCRIPTS_JS']); ?>
	<?php echo $this->Html->script('/assets/admin/layout/scripts/demo.js', ['block' => 'PAGE_LEVEL_SCRIPTS_JS']); ?>
	<?php echo $this->Html->script('/assets/admin/pages/scripts/components-dropdowns.js', ['block' => 'PAGE_LEVEL_SCRIPTS_JS']); ?>
	<!-- END COMPONENTS DROPDOWNS -->
<!-- END PAGE LEVEL SCRIPTS -->

<?php
	$js="
	$(document).ready(function() { 
		$('.attrGet').die().live('change',function(){
		var itemQ=$(this).closest('tr');
		var gst_amount=$('option:selected', this).attr('gst_amount');
		var sales_rate=$('option:selected', this).attr('sales_rate');
		$(this).closest('tr').find('.gst_amount').val(gst_amount);
		$(this).closest('tr').find('.rate').val(sales_rate);
		var itemId=$(this).val();
		var url='".$this->Url->build(["controller" => "SalesInvoices", "action" => "ajaxItemQuantity"])."';
		url=url+'/'+itemId
		$.ajax({
			url: url,
			type: 'GET'
			//dataType: 'text'
		}).done(function(response) {
			var fetch=$.parseJSON(response);
			var text=fetch.text;
			var type=fetch.type;
			var mainStock=fetch.mainStock;
			itemQ.find('.itemQty').html(text);
			itemQ.find('.totStock').val(mainStock);
		if(type=='true')
		{
		 itemQ.find('.outStock').val(1);
		}
		else{
		 itemQ.find('.outStock').val(0);
		}
		});	
		forward_total_amount();
		});
		
		$('.party_ledger_id').die().live('change',function(){
			var customer_state_id=$('option:selected', this).attr('party_state_id');
			if(!customer_state_id){customer_state_id=0;}
			var state_id=$('.state_id').val();
			if(customer_state_id!=state_id)
			{
			if(customer_state_id>0)
			{
				$('#gstDisplay').html('IGST');
				$('#add_igst').show();
				$('#add_cgst').hide();
				$('#add_sgst').hide();
				$('#is_interstate').val('1');
			}
			else if(!customer_state_id)
			{
				$('#gstDisplay').html('GST');
				$('#add_cgst').show();
				$('#add_sgst').show();
				$('#add_igst').hide();
				$('#is_interstate').val('0');
			}
			else if(customer_state_id==0)
			{
				$('#gstDisplay').html('GST');
				$('#add_cgst').show();
				$('#add_sgst').show();
				$('#add_igst').hide();
				$('#is_interstate').val('0');
			}
			}
			else if(customer_state_id==state_id){
				$('#gstDisplay').html('GST');
				$('#add_cgst').show();
				$('#add_sgst').show();
				$('#add_igst').hide();
				$('#is_interstate').val('0');
			}
		});
		
	
		ComponentsPickers.init();
	});
	/* $('.quantity').die().live('keyup',function(){
			var quantity=$(this).val();
			$(this).closest('tr').find('.exactQty').val(quantity);
	}); */

	
	$( document ).ready( stockLoad );
	function stockLoad()
	{
	$('#main_table tbody#main_tbody tr.main_tr').each(function(){ 
		var itemQ=$(this).closest('tr');
		var gst_amount=$('option:selected', this).attr('gst_amount');
		var itemId=$('option:selected', this).attr('value');
		var sales_rate=$('option:selected', this).attr('sales_rate');
		$(this).closest('tr').find('.gst_amount').val(gst_amount);
		//$(this).closest('tr').find('.rate').val(sales_rate);
		//var itemId=$(this).val();
		var url='".$this->Url->build(["controller" => "SalesInvoices", "action" => "ajaxItemQuantity"])."';
		url=url+'/'+itemId
		$.ajax({
			url: url,
			type: 'GET'
		}).done(function(response) {
			var fetch=$.parseJSON(response);
			var text=fetch.text;
			var type=fetch.type;
			var mainStock=fetch.mainStock;
			itemQ.find('.itemQty').html(text);
			itemQ.find('.totStock').val(mainStock);
			if(type=='true')
			{
			 itemQ.find('.outStock').val(1);
			}
			else{
			 itemQ.find('.outStock').val(0);
			}
		});	
		});
	}
rename_rows();
	$('.rename_check').die().live('click',function() {
		
		rename_rows();   
    });	
	
	function rename_rows()
	{
		var i=0;
		$('#main_table tbody#main_tbody tr.main_tr').each(function(){ 
			//var val=$(this).find('.rename_check').val();
			var val=$(this).find('input[type=checkbox]:checked').val();
			
		if(val){ 
			$(this).find('td:nth-child(1) input.id').attr({name:'sale_return_rows['+i+'][sales_invoice_row_id]',id:'sale_return_rows['+i+'][sales_invoice_row_id]'});
			$(this).find('td:nth-child(1) select.attrGet').attr({name:'sale_return_rows['+i+'][item_id]',id:'sale_return_rows['+i+'][item_id]'});
		  $(this).find('.quantity').attr({name:'sale_return_rows['+i+'][quantity]',id:'sale_return_rows['+i+'][quantity]'});
		 
			var max_qty=$(this).find('.quantity').val();
			$(this).find('.rate').attr({name:'sale_return_rows['+i+'][rate]',id:'sale_return_rows['+i+'][rate]'});
		  $(this).find('.discount').attr({name:'sale_return_rows['+i+'][discount_percentage]',id:'sale_return_rows['+i+'][discount_percentage]'});
		  
		  $(this).find('.gstAmount').attr({name:'sale_return_rows['+i+'][taxable_value]',id:'sale_return_rows['+i+'][taxable_value]'});
		  
		  $(this).find('.gst_figure_id').attr({name:'sale_return_rows['+i+'][gst_figure_id]',id:'sale_return_rows['+i+'][gst_figure_id]'});
		  
		  $(this).find('.discountAmount').attr({name:'sale_return_rows['+i+'][net_amount]',id:'sale_return_rows['+i+'][net_amount]'});
		  $(this).find('.gstValue').attr({name:'sale_return_rows['+i+'][gst_value]',id:'sale_return_rows['+i+'][gst_value]'});
		$(this).find('.returnQty').attr({name:'sale_return_rows['+i+'][return_quantity]',id:'sale_return_rows['+i+'][return_quantity]'}).attr('max', max_qty).removeAttr('readonly');
		  
		$(this).css('background-color','#fffcda');
		i++;
		}else{
			$(this).find('td:nth-child(1) input.id').attr({name:'q'});

			$(this).find('td:nth-child(1) select.attrGet').attr({name:'q'});
			$(this).find('.quantity').attr({name:'q'});
		  $(this).find('.rate').attr({name:'q'});
		  $(this).find('.discount').attr({name:'q'});
		  
		  $(this).find('.gstAmount').attr({name:'q'});
		  
		  $(this).find('.gst_figure_id').attr({name:'q'});
		  
		  $(this).find('.discountAmount').attr({name:'q'});
		  $(this).find('.gstValue').attr({name:'q'});
		  $(this).find('.returnQty').attr({name:'q' , readonly:'readonly'});
		$(this).css('background-color','#FFF');
		}

		});
	}
	
	$('.calculation').die().live('blur',function()
	{
		forward_total_amount();
	});
	//$( document ).ready( forward_total_amount );
	$( document ).ready( partyOnLoad );
		
		function partyOnLoad()
		{
			var customer_state_id=$('.ps').val();
			var state_id=$('.state_id').val();
			if(customer_state_id!=state_id)
			{
			if(customer_state_id>0)
			{
				$('#gstDisplay').html('IGST');
				$('#add_igst').show();
				$('#add_cgst').hide();
				$('#add_sgst').hide();
				$('#is_interstate').val('1');
			}
			else if(!customer_state_id)
			{
				$('#gstDisplay').html('GST');
				$('#add_cgst').show();
				$('#add_sgst').show();
				$('#add_igst').hide();
				$('#is_interstate').val('0');
			}
			else if(customer_state_id==0)
			{
				$('#gstDisplay').html('GST');
				$('#add_cgst').show();
				$('#add_sgst').show();
				$('#add_igst').hide();
				$('#is_interstate').val('0');
			}
			}
			else if(customer_state_id==state_id){
				$('#gstDisplay').html('GST');
				$('#add_cgst').show();
				$('#add_sgst').show();
				$('#add_igst').hide();
				$('#is_interstate').val('0');
			}
		}
			
		function forward_total_amount()
		{ 
			var total  = 0;
			var gst_amount  = 0;
			var gst_value  = 0;
			var s_cgst_value=0;
			var roundOff1=0;
			var round_of=0;
			var isRoundofType=0;
			var igst_value=0;
			var outOfStockValue=0;
			var s_igst=0;
			var newsgst=0;
			var newigst=0;
			var exactgstvalue=0;		
			$('#main_table tbody#main_tbody tr.main_tr').each(function()
			{
			
			    var outdata=$(this).closest('tr').find('.outStock').val();
				if(!outdata){outdata=0;}
				outOfStockValue=parseFloat(outOfStockValue)+parseFloat(outdata);
			
			    var gstpaid=$('option:selected', this).attr('gst_amount');
			    $(this).closest('tr').find('.gst_amount').val(gstpaid);
			
				var quantity  = Math.round($(this).find('.returnQty').val());
				if(!quantity){quantity=0;}
				var rate  = parseFloat($(this).find('.rate').val());
				if(!rate){rate=0;}
				var totamount = quantity*rate;
				$(this).find('.totamount').val(totamount);
				   
				var discount  = parseFloat($(this).find('.discount').val());
				if(!discount){discount=0;}
				var discountValue=(discount*totamount)/100;
				var discountAmount=totamount-discountValue;
				$(this).find('.discountAmount').val(discountAmount.toFixed(2));

				var gst_ietmamount  = $(this).find('.gst_amount').val();
				var discountAmount  = $(this).find('.discountAmount').val();
				var item_gst_amount=discountAmount/quantity;
				
				if(item_gst_amount<=gst_ietmamount)
				{
					var first_gst_figure_tax_percentage=$('option:selected', this).attr('FirstGstFigure');
					var first_gst_figure_tax_name=$('option:selected', this).attr('FirstGstFigure');
					var first_gst_figure_id=$('option:selected', this).attr('first_gst_figure_id');
						
					$(this).closest('tr').find('.gst_figure_id').val(first_gst_figure_id);
					$(this).closest('tr').find('.gst_figure_tax_percentage').val(first_gst_figure_tax_percentage);
					$(this).closest('tr').find('.gst_figure_tax_name').val(first_gst_figure_tax_name);
                }
				else if(item_gst_amount>gst_ietmamount)
				{
					var second_gst_figure_tax_percentage=$('option:selected', this).attr('SecondGstFigure');
					var second_gst_figure_tax_name=$('option:selected', this).attr('SecondGstFigure');
					var second_gst_figure_id=$('option:selected', this).attr('second_gst_figure_id');

					$(this).closest('tr').find('.gst_figure_id').val(second_gst_figure_id);
					$(this).closest('tr').find('.gst_figure_tax_percentage').val(second_gst_figure_tax_percentage);
					$(this).closest('tr').find('.gst_figure_tax_name').val(second_gst_figure_tax_name);
				}
				
				$(this).find('.discountvalue').val(discountValue.toFixed(2));
				
				var gst_figure_tax_percentage  = parseFloat($(this).find('.gst_figure_tax_percentage').val());
				if(!gst_figure_tax_percentage){gst_figure_tax_percentage=0;}
				var discountAmount  = parseFloat($(this).find('.discountAmount').val());
				if(!discountAmount){discountAmount=0;}
			    var divideValue=100;
				var divideval=divideValue+gst_figure_tax_percentage;
				var gstAmount=(discountAmount*100)/divideval;
	            var gstValue=(gstAmount*gst_figure_tax_percentage)/100;
				$(this).find('.gstAmount').val(gstAmount.toFixed(2));
				$(this).find('.gstValue').val(gstValue.toFixed(2));

				
				
				var gstValue  = parseFloat($(this).find('.gstValue').val());
				var gstAmount  = parseFloat($(this).find('.gstAmount').val());
				var is_interstate  = parseFloat($('#is_interstate').val());
				if(is_interstate=='0')
				{
					 exactgstvalue=round(gstValue/2,2);
					 $(this).find('.exactgst_value').val(exactgstvalue);
					var add_cgst  = $(this).find('.exactgst_value').val();
					if(!add_cgst){add_cgst=0;}
					//alert(add_cgst);
					newsgst=round(parseFloat(newsgst)+parseFloat(add_cgst), 2);
					gst_amount=parseFloat(gst_amount.toFixed(2))+parseFloat(gstAmount.toFixed(2));
					total=gst_amount+newsgst+newsgst;
					roundOff1=Math.round(total);
				}else{
					 exactgstvalue=round(gstValue,2);
					 $(this).find('.exactgst_value').val(exactgstvalue);
					var add_igst  = parseFloat($(this).find('.exactgst_value').val());
					if(!add_igst){add_igst=0;}
					newigst=round(parseFloat(newigst)+parseFloat(add_igst), 2);
					gst_amount=parseFloat(gst_amount.toFixed(2))+parseFloat(gstAmount.toFixed(2));
					total=gst_amount+newigst;
					roundOff1=Math.round(total);
				}
				if(total<roundOff1)
				{
					round_of=parseFloat(roundOff1)-parseFloat(total);
					isRoundofType='0';
				}
				if(total>roundOff1)
				{
					round_of=parseFloat(roundOff1)-parseFloat(total);
					isRoundofType='1';
				}
				if(total==roundOff1)
				{
					round_of=parseFloat(total)-parseFloat(roundOff1);
					isRoundofType='0';
				}
				
			});
			$('.amount_after_tax').val(roundOff1.toFixed(2));
			$('.amount_before_tax').val(gst_amount.toFixed(2));
			$('.add_cgst').val(newsgst);
			$('.add_sgst').val(newsgst);
			$('.add_igst').val(newigst);					
			$('.roundValue').val(round_of.toFixed(2));
			$('.isRoundofType').val(isRoundofType);
			$('.outOfStock').val(outOfStockValue);
			rename_rows();
		}
		
	function checkValidation() 
	{  
		var amount_before_tax  = parseFloat($('.amount_before_tax').val());
		if(!amount_before_tax || amount_before_tax==0){
			alert('Error: zero amount invoice can not be generated.');
			return false;
		}
		
		var StockDB=[]; var StockInput = {};
		$('#main_table tbody#main_tbody tr.main_tr').each(function()
		{
			var stock=$(this).find('td:nth-child(1) input.totStock').val();
			var item_id=$(this).find('td:nth-child(1) select.attrGet option:selected').val();
			var actualQuantity=parseFloat($(this).find('td:nth-child(2) input.quantity').val());
			var exactQty=parseFloat($(this).find('td:nth-child(1) input.exactQty').val());
			var existingQty=parseFloat(StockInput[item_id]);
			var quantity=parseFloat(actualQuantity)-parseFloat(exactQty);
			if(!existingQty){ existingQty=0; }
			StockInput[item_id] = quantity+existingQty;
			StockDB[item_id] = stock;
		});
		
		var c=1;
		$('#main_table tbody#main_tbody tr.main_tr').each(function()
		{
			var item_id=$(this).find('td:nth-child(1) select.attrGet option:selected').val();
			if(StockInput[item_id]>StockDB[item_id]){
				c=0;
			}
		});
		if(c==0){
			alert('Error: Stock is going in minus.');
			return false;
		}
		
		if(confirm('Are you sure you want to submit!'))
		{
			$('.submit').attr('disabled','disabled');
			$('.submit').text('Submiting...');
			return true;
		}
		else
		{
			return false;
		}
	}

	
	
/* function checkValidation() 
	{  
		var amount_before_tax  = $('.amount_before_tax').val();
		var amount_after_tax = $('.amount_after_tax').val();
		var outOfStock = $('.outOfStock').val();
		if(amount_before_tax && amount_after_tax && outOfStock==0)
		{
			if(confirm('Are you sure you want to submit!'))
			{
			     $('.submit').attr('disabled','disabled');
	             $('.submit').text('Submiting...');
				 return true;
			}
			else
			{
				return false;
			}
		}
		else if(outOfStock>0) {
		       alert('Please check, you have added out of stock data!');
			   return false;
		}

	} */";

echo $this->Html->scriptBlock($js, array('block' => 'scriptBottom')); 
?>
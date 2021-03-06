  <div class="row">
	<div class="col-md-12 ">
		<div class="col-md-7">
		<h3><?php echo $title;?><small>Click on any one to view </small></h3>
		
		<small>All amounts displayed in crores of rupees.</small>
		</div>
		<div class="col-md-5 pull-right">
			<?php if(count($states)>1){ ?>
			<?php echo form_open("reports/summary/$type",array('class'=>'form-custom')); ?>
			Select State
			<select name="state" class="form-control">
				<option value="">All</option>
				<option value="1">Andhra Pradesh</option>
				<option value="2">Telangana</option>
			</select>
			<input type="submit" class="btn btn-primary" name="state_submit" value="Submit" />
			</form>
			<?php } ?>
		</div>
	<div class="col-md-12">
	
		<div class="col-md-5 pull-right">
		<input id="colSelect1" type="checkbox" class="sr-only" hidden />
		<label class="btn btn-default btn-md" for="colSelect1">Select Columns</label>
		<div id="columnSelector" class="columnSelector col-md-4"></div>
		<button type="button" class="btn btn-default btn-md print">
		  <span class="glyphicon glyphicon-print"></span> Print
		</button>
		</div>
	</div>
	<div class="row"></div>
	<h5>
		<?php if(count($states)>1){ ?>
				<?php if($this->input->post('state')){
							if($this->input->post('state')=="TS") echo "Telangana";
							else if($this->input->post('state')=="AP") echo "Andhra Pradesh";
						}
					else echo "Andhra Pradesh and Telangana";
				?>
		<?php } ?>
	</h5>
	<table class="table table-hover table-striped table-bordered tablesorter" id="table-1">
	<thead>
		<tr>
		<th data-priority="critical">S.No</th>
		<th data-priority="critical" data-name="name"><?php echo $name;?></th>
		<th>AS</th>
		<th>TS</th>
		<th>Agt</th>
		<th>Cum. Exp. prev. years</th>
		<th>Exp. DY upto <?php if($this->input->post('month')&& $this->input->post('year')) { ?>
		<small><?php echo date("M", mktime(0, 0, 0, $this->input->post('month'),  0, 0)).", ".$this->input->post('year');?>
		<?php } else { echo date("M, Y",strtotime("last month"));} ?>
		</small></th>
		<th>Target DY upto <?php if($this->input->post('month')&& $this->input->post('year')) { ?>
		<small><?php echo date("M", mktime(0, 0, 0, $this->input->post('month'),  0, 0)).", ".$this->input->post('year');?>
		<?php } else { echo date("M, Y",strtotime("last month"));} ?>
		</small></th>
		<th>%Ach During year</th>
		<th>Exp. DM <?php if($this->input->post('month')&& $this->input->post('year')) { ?>
		<small><?php echo date("M", mktime(0, 0, 0, $this->input->post('month')+1,  0, 0)).", ".$this->input->post('year');?></small>
		<?php } else{ echo date("M, Y"); } ?></th>
		<th>Target DM <?php if($this->input->post('month')&& $this->input->post('year')) { ?>
		<small><?php echo date("M", mktime(0, 0, 0, $this->input->post('month')+1,  0, 0)).", ".$this->input->post('year');?></small>
		<?php } else{ echo date("M, Y"); } ?></th>
		<th>Cum. Exp</th>
		<th>Pending Bills</th>
		<th>Total Target for the year</th>
		<th>Exp % over TS</th>
		<th>Balance</th>
		<th>Total Works</th>
		<th>Not Started</th>
		<th>In Progress</th>
		<th>Completed</th>
		<th>Medical</th>
		<th>Non Medical</th>
		</tr>
	</thead>
	<tbody>

	<?php
	$admin_sanction_amount=0;
	$tech_sanction_amount=0;
	$agreement_amount=0;
	$total_projects=0;
	$not_started=0;
	$work_in_progress=0;
	$work_completed=0;
	$medical=0;
	$non_medical=0;
	$expenses=0;
	$expenses_prev=0;
	$expenses_current=0;
	$expenses_current_month=0;
	$targets_current=0;
	$targets_current_month=0;
	$targets_total=0;
	$pending_bills=0;
	$i=1;
	foreach($summary as $row){
	?>
	<tr onclick="$('#select_form_<?php echo $row->$id;?>').submit();">
		<td>
			<?php echo form_open("reports/summary/$type",array('id'=>'select_form_'.$row->$id,'role'=>'form')); ?>
			<?php echo $i++; ?>
		</td>
		<td><?php echo $row->$col_name; ?>
		<?php if($this->input->post('state')) { ?>
		<input type='hidden' value="<?php echo $this->input->post('state'); ?>" name="state" />
		<?php } ?>
		<input type='hidden' value="<?php if($row->$id!=NULL) echo $row->$id; else echo "'0'" ?>" name="<?php echo $id;?>" />
		</td>
		<td class="text-right"><?php echo number_format($row->admin_sanction_amount/10000000,2); ?></td>
		<td class="text-right"><?php echo number_format($row->tech_sanction_amount/10000000,2); ?></td>
		<td class="text-right"><?php echo number_format($row->agreement_amount/10000000,2); ?></td>
		<td class="text-right"><?php echo number_format($row->expenses_last_year/10000000,2); ?></td>
		<td class="text-right"><?php echo number_format($row->expenses_current_year/10000000,2); ?></td>
		<td class="text-right"><?php echo number_format($row->targets_current_year/10000000,2); ?></td>
		<td class="text-right"><?php if($row->targets_current_year>0) echo number_format(($row->expenses_current_year/$row->targets_current_year)*100,2); else echo 0;?>%</td>
		<td class="text-right"><?php echo number_format($row->expense_current_month/10000000,2); ?></td>
		<td class="text-right"><?php echo number_format($row->target_current_month/10000000,2); ?></td>
		<td class="text-right"><?php echo number_format(($row->expenses_current_year+$row->expenses_last_year)/10000000,2); ?></td>
		<td class="text-right"><?php echo number_format($row->bills_pending/10000000,2); ?></td>
		<td class="text-right"><?php echo number_format($row->targets_total_year/10000000,2); ?></td>
		<td class="text-right"><?php echo number_format(($row->expenses_current_year+$row->expenses_last_year)/$row->tech_sanction_amount*100);echo "%" ?></td>
		<td class="text-right"><?php echo number_format(($row->admin_sanction_amount-($row->expenses_current_year+$row->expenses_last_year))/10000000,2); ?></td>
		<td class="text-right"><?php echo $row->total_projects; ?></td>
		<td class="text-right"><?php echo $row->not_started; ?></td>
		<td class="text-right"><?php echo $row->work_in_progress; ?></td>
		<td class="text-right"><?php echo $row->work_completed; ?></td>
		<td class="text-right"><?php echo $row->medical; ?></td>
		<td class="text-right"><?php echo $row->non_medical; ?>
			</form>
		</td>
	</tr>
	<?php
	$admin_sanction_amount+=$row->admin_sanction_amount;
	$tech_sanction_amount+=$row->tech_sanction_amount;
	$agreement_amount+=$row->agreement_amount;
	$total_projects+=$row->total_projects;
	$not_started+=$row->not_started;
	$work_in_progress+=$row->work_in_progress;
	$work_completed+=$row->work_completed;
	$medical+=$row->medical;
	$non_medical+=$row->non_medical;
	$expenses_prev+=$row->expenses_last_year;
	$expenses_current+=$row->expenses_current_year;
	$expenses_current_month+=$row->expense_current_month;
	$targets_current+=$row->targets_current_year;
	$targets_current_month+=$row->target_current_month;
	$expenses+=$row->expenses_last_year+$row->expenses_current_year;
	$targets_total+=$row->targets_total_year;
	$pending_bills+=$row->bills_pending;
	}
	?>
	</tbody>
	<tr onclick="$('#select_form_all').submit();">
		<th colspan="2">	
			<?php echo form_open("reports/summary/$type",array('id'=>'select_form_all','role'=>'form')); ?>
				<input type='hidden' value="0" form="select_form_all" name="<?php echo $id;?>" />
			</form>
			Total
		</th>
		<th class="text-right"><?php echo number_format($admin_sanction_amount/10000000,2);?></th>
		<th class="text-right"><?php echo number_format($tech_sanction_amount/10000000,2);?></th>
		<th class="text-right"><?php echo number_format($agreement_amount/10000000,2);?></th>
		<th class="text-right"><?php echo number_format($expenses_prev/10000000,2);?></th>
		<th class="text-right"><?php echo number_format($expenses_current/10000000,2);?></th>
		<th class="text-right"><?php echo number_format($targets_current/10000000,2);?></th>
		<th class="text-right"><?php echo number_format(($expenses_current/$targets_current)*100,2);?>%</th>
		<th class="text-right"><?php echo number_format($expenses_current_month/10000000,2);?></th>
		<th class="text-right"><?php echo number_format($targets_current_month/10000000,2);?></th>
		<th class="text-right"><?php echo number_format($expenses/10000000,2);?></th>
		<th class="text-right"><?php echo number_format($pending_bills/10000000,2);?></th>
		<th class="text-right"><?php echo number_format($targets_total/10000000,2);?></th>
		<th class="text-right"><?php echo number_format(($expenses/$tech_sanction_amount)*100,2);?>%</th>
		<th class="text-right"><?php echo number_format(($admin_sanction_amount-$expenses)/10000000,2);?></th>
		<th class="text-right"><?php echo $total_projects;?></th>
		<th class="text-right"><?php echo $not_started;?></th>
		<th class="text-right"><?php echo $work_in_progress;?></th>
		<th class="text-right"><?php echo $work_completed;?></th>
		<th class="text-right"><?php echo $medical;?></th>
		<th class="text-right"><?php echo $non_medical;?></th>
	</tr>
	</table>
	</div>
	</div>

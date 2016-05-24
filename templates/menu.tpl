{extends file="page.tpl"}

{block name="header"}{/block}

{block name="messages"}{/block}						

{block name="content"}

	<div class="form-group">
		<span class="col-sm-offset-3 col-sm-6">
			<div class="input-group">
				<span class="input-group-btn">
					<button id="prev" class="btn btn-default" type="button" disabled="disabled" onclick="faculty_journal_menu.previousStudent();">
						<span class="glyphicon glyphicon-chevron-left"></span>
					</button>
				</span>
				<select class="form-control" id="students" disabled="disabled" onchange="faculty_journal_menu.update()">
					<option id="placeholder">
						Loading students&hellip;
					</option>
				</select>
				<span class="input-group-btn">
					<button id="next" class="btn btn-default" type="button" disabled="disabled" onclick="faculty_journal_menu.nextStudent();">
						<span class="glyphicon glyphicon-chevron-right"></span>
					</button>
				</span>
			</div>
		</span>
	</div>

{/block}

{block name="footer"}{/block}

{block name="post-bootstrap-scripts"}

	<script src="js/menu.js"></script>
	<script type="text/javascript">
		
		faculty_journal_menu.init('{$pluginUrl}', '{$canvasInstance}', '{$course}', '{$name}', '{$user}');
			
	</script>

{/block}
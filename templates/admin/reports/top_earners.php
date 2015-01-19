<?php
use Jigoshop\Helper\Product;

/**
 * @var $orders array List of currently processed orders.
 * @var $sales array Data about product sales.
 * @var $chart array Data for pie chart.
 * @var $total_sales float Total sales amount.
 */
?>
<div class="span3 thumbnail">
	<h2><?php _e('Top Earners','jigoshop'); ?></h2>
	<div id="top_earners_pie_keys" style="margin-top:20px;"></div>
	<div id="top_earners_pie" style="height:300px"></div>
	<table class="table table-condensed">
		<thead>
		<tr>
			<th><?php _e('Product', 'jigoshop'); ?></th>
			<th><?php _e('Sales', 'jigoshop'); ?></th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($sales as $id => $salesData):
			/** @var \Jigoshop\Entity\Product $product */
			$product = $salesData['product'];
			$label = !empty($product) ? sprintf('<a href="%s">%s</a>', $product->getLink(), $product->getName()) : __('Product no longer exists', 'jigoshop');
			?>
			<tr>
				<td><?php echo $label; ?></td>
				<td><?php echo Product::formatPrice($salesData['value']); ?></td>
			</tr>
		<?php endforeach; ?>
		</tbody>
		<tfoot>
		<tr>
			<th><?php _e('Total Sales', 'jigoshop'); ?></th>
			<th><?php echo Product::formatPrice($total_sales); ?></th>
		</tr>
		</tfoot>
	</table>

	<script type="text/javascript">
		/* <![CDATA[ */
		jQuery(function($){
			var data = [];
			data = <?php echo json_encode($chart); ?>;
			$.plot($("#top_earners_pie"), data, {
				series: {
					pie: {
						show: true,
						combine: {
							color: '#999',
							threshold: 0.045 /* rounding up for 5% */
						},
						radius: 1,
						label: {
							show: true,
							radius: 2/3,
							formatter: function(label, series){
								return '<div style="font-size:8pt;text-align:center;padding:2px;color:black;">'+Math.round(series.percent)+'%</div>';
							}
						}
					}
				},
				legend: {
					show: true,
					container: $("#top_earners_pie").prev()
				}
			});
		});
		/* ]]> */
	</script>
</div>
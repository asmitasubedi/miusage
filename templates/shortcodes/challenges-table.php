<?php
/**
 * The Template for displaying Miusage Challenges table.
 *
 * @package Miusage\Templates
 * @since 1.0.0
 */

use Miusage\Helpers\Helpers;

defined( 'ABSPATH' ) || exit;

$caption = isset( $data['title'] ) ? $data['title'] : false;
$headers = isset( $data['data']['headers'] ) ? $data['data']['headers'] : false;
$rows    = isset( $data['data']['rows'] ) ? $data['data']['rows'] : false;

?>
<div class="miusage-challenge-data">
	<table class="miusage-challenge-data-table">

		<?php if ( $caption ) : ?>
			<caption><?php echo esc_html( $caption ); ?></caption>
		<?php endif; ?>

		<?php if ( $headers ) : ?>
			<thead>
				<tr>
					<?php foreach ( $headers as $header ) { ?>
						<th><?php echo esc_html( $header ); ?></th>
					<?php } ?>
				</tr>
			</thead>
		<?php endif; ?>

		<?php if ( $rows ) : ?>
			<tbody>
				<?php foreach ( $rows as $row ) { ?>
					<tr>
						<?php
						foreach ( $row as $key => $cell ) {
							$cell = 'date' !== $key ? $cell : date_i18n(
								Helpers::datetime_format(),
								$cell
							);
							?>
							<td data-label="<?php echo esc_html( $key ); ?>"><?php echo esc_html( $cell ); ?></td>
						<?php } ?>
					</tr>
				<?php } ?>
			</tbody>
		<?php endif; ?>
	</table>
</div>
<?php

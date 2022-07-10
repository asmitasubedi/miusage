<?php
/**
 * The Template for displaying Miusage Challenges table.
 *
 * @package Miusage\Templates
 * @since 1.0.0
 */

use Miusage\Helpers\Helpers;

defined( 'ABSPATH' ) || exit;

$ids    = array_keys( $rows[1] );
$labels = array_values( $headers );

$headers = array_combine( $ids, $labels );

?>
<div class="miusage-challenge-data">
	<table class="miusage-challenge-data-table">

		<?php if ( $caption && $toggles['show_title'] ) : ?>
			<caption><?php echo esc_html( $caption ); ?></caption>
		<?php endif; ?>

		<?php if ( $headers ) : ?>
			<thead>
				<tr>
					<?php foreach ( $headers as $key => $header ) : ?>
						<?php if ( $toggles[ 'show_' . $key ] ) : ?>
							<th><?php echo esc_html( $header ); ?></th>
						<?php endif; ?>
					<?php endforeach; ?>
				</tr>
			</thead>
		<?php endif; ?>

		<?php if ( $rows ) : ?>
			<tbody>
				<?php foreach ( $rows as $row ) : ?>
					<tr>
						<?php if ( $toggles['show_id'] ) : ?>
							<td data-label="<?php echo esc_html__( 'ID', 'miusage' ); ?>"><?php echo esc_html( $row['id'] ); ?></td>
						<?php endif; ?>

						<?php if ( $toggles['show_fname'] ) : ?>
							<td data-label="<?php echo esc_html__( 'First Name', 'miusage' ); ?>"><?php echo esc_html( $row['fname'] ); ?></td>
						<?php endif; ?>

						<?php if ( $toggles['show_lname'] ) : ?>
							<td data-label="<?php echo esc_html__( 'Last Name', 'miusage' ); ?>"><?php echo esc_html( $row['lname'] ); ?></td>
						<?php endif; ?>

						<?php if ( $toggles['show_email'] ) : ?>
							<td data-label="<?php echo esc_html__( 'Email', 'miusage' ); ?>"><?php echo esc_html( $row['email'] ); ?></td>
						<?php endif; ?>

						<?php if ( $toggles['show_date'] ) : ?>
							<td data-label="<?php echo esc_html__( 'Date', 'miusage' ); ?>">
								<?php echo esc_html( Helpers::format_datetime( $row['date'] ) ); ?>
							</td>
						<?php endif; ?>
					</tr>
				<?php endforeach; ?>
			</tbody>
		<?php endif; ?>
	</table>
</div>
<?php

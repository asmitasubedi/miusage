<?php
/**
 * The Template for displaying Miusage Challenges table.
 *
 * @package Miusage\Templates
 * @since 1.0.0
 */

use Miusage\Helpers\Helpers;

defined( 'ABSPATH' ) || exit;

$dictionary = array(
	'id'    => 'ID',
	'fname' => 'First Name',
	'lname' => 'Last Name',
	'email' => 'Email',
	'date'  => 'Date',
);

$columns = array();
foreach ( $dictionary as $key => $value ) {
	if ( isset( $attributes[ 'show_' . $key ] ) && $attributes[ 'show_' . $key ] ) {
		$columns[ $key ] = $value;
	}
}

?>
<div class="miusage-challenge-data">
	<table class="miusage-challenge-data-table">

		<?php if ( $caption && $show_title ) : ?>
			<caption><?php echo esc_html( $caption ); ?></caption>
		<?php endif; ?>

		<?php if ( $headers ) : ?>
			<thead>
				<tr>
					<?php foreach ( $headers as $header ) : ?>
						<th><?php echo esc_html( $header ); ?></th>
					<?php endforeach; ?>
				</tr>
			</thead>
		<?php endif; ?>

		<?php if ( $rows ) : ?>
			<tbody>
				<?php foreach ( $rows as $row ) : ?>
					<tr>
						<?php if ( $show_id ) : ?>
							<td data-label="<?php echo esc_html__( 'ID', 'miusage' ); ?>"><?php echo esc_html( $row['id'] ); ?></td>
						<?php endif; ?>

						<?php if ( $show_fname ) : ?>
							<td data-label="<?php echo esc_html__( 'First Name', 'miusage' ); ?>"><?php echo esc_html( $row['fname'] ); ?></td>
						<?php endif; ?>

						<?php if ( $show_lname ) : ?>
							<td data-label="<?php echo esc_html__( 'Last Name', 'miusage' ); ?>"><?php echo esc_html( $row['lname'] ); ?></td>
						<?php endif; ?>

						<?php if ( $show_email ) : ?>
							<td data-label="<?php echo esc_html__( 'Email', 'miusage' ); ?>"><?php echo esc_html( $row['email'] ); ?></td>
						<?php endif; ?>

						<?php if ( $show_date ) : ?>
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

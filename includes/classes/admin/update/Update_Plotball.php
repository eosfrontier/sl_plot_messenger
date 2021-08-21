<?php
namespace frontier\ploball\admin\update;

use frontier\ploball\database\Crud;

class Update_Plotball {

	/**
	 * Insert a new plotbal in the database
	 *
	 * @param  mixed $post Array of data.
	 * @return bool
	 */
	public static function update( $post ) {

		unset( $post['xf'] );

		$validations = [];

		$id['id'] = $post['id'];

		$post['bounce'] = implode( ',', $post['bounce'] );

		if ( isset( $post['main_skills_validations'] ) ) {
			$validations['main_skills_validations'] = $post['main_skills_validations'];
			unset( $post['main_skills_validations'] );
		}

		if ( isset( $post['specialty_skills_validations'] ) ) {
			$validations['specialty_skills_validations'] = $post['specialty_skills_validations'];
			unset( $post['specialty_skills_validations'] );
		}

		if ( isset( $post['faction_validations'] ) ) {
			$validations['faction_validations'] = $post['faction_validations'];
			unset( $post['faction_validations'] );
		}

		if ( ! empty( $post['custom_validation'] ) ) {
			$validations['custom_validation'] = $post['custom_validation'];
		}
		unset( $post['custom_validation'] );

		$customdate   = $post['starting-date'] . ' ' . $post['starting-time'];
		$datetime     = date_create_from_format( 'Y-m-d H:i', $customdate );
		$startingtime = strtotime( $datetime->format( 'Y-m-d H:i:s' ) );
		unset( $post['starting-date'] );
		unset( $post['starting-time'] );

		$post['start_date']  = $startingtime;
		$post['validations'] = json_encode( $validations );

		$return = Crud::update( 'plotball', $post, $id );

		return $return;
	}
}

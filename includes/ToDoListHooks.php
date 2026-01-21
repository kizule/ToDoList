<?php

use OOUI\CheckboxInputWidget;

/**
 * Hooks used by ToDoList extension
 */
class ToDoListHooks {
	/**
	 * We extend parser here.
	 * Parser will process our custom tag: <todo>
	 *
	 * @param Parser $parser
	 */
	public static function onParserSetup( $parser ) {
		$parser->setHook( 'todo', 'ToDoListHooks::processToDoListTag' );
	}

	/**
	 * Implementation of the '<todo>' tag processing
	 *
	 * @param string $input
	 * @param array $args
	 * @param Parser $parser
	 * @param PPFrame $frame
	 * @return array
	 */
	public static function processToDoListTag( $input, array $args, $parser, PPFrame $frame ) {
		$out = $parser->getOutput();
		\OutputPage::setupOOUI();
		$out->setEnableOOUI( true );
		$out->addModules( [ 'ext.ToDoList' ] );

		$isDone = false;
		if ( isset( $args['done'] ) ) {
			$isDone = filter_var( $args['done'], FILTER_VALIDATE_BOOLEAN );
		}

		// phpcs:ignore Generic.Files.LineLength.TooLong
		// return '<input type="checkbox" class="todo-checkbox oo-ui-inputWidget-input"' . ( $isDone ? ' checked' : '' ) . '>';

		$checkboxControl = new CheckboxInputWidget( [
			'selected' => $isDone,
			'classes' => [ 'todo-checkbox' ]
		] );
		return [ $checkboxControl->toString(), 'markerType' => 'nowiki' ];
	}
}

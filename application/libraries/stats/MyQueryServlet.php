<?php
/**
 * Query Example Servlet class
 *
 * This class creates a DataTable with static data.  You should
 * obviously update this to get the data from your source.
 *
 * This creates a data table with multiple row and column fields
 * to demonstrate the pivot capabilities of this library.
 *
 * @author Ross Perkins <ross@vubeology.com>
 */

use Vube\GoogleVisualization\DataSource\DataTable\ColumnDescription;
use Vube\GoogleVisualization\DataSource\DataTable\DataTable;
use Vube\GoogleVisualization\DataSource\DataTable\TableRow;
use Vube\GoogleVisualization\DataSource\DataTable\Value\ValueType;
use Vube\GoogleVisualization\DataSource\Date;
use Vube\GoogleVisualization\DataSource\Request;
use Vube\GoogleVisualization\DataSource\Servlet;

/**
 * MyServlet class
 * 
 * @author Ross Perkins <ross@vubeology.com>
 */
class MyQueryServlet extends Servlet {

	private $dataTable;

	/**
	 * Constructor
	 *
	 * This disables restricted access mode so that you can execute
	 * this query from anywhere.
	 *
	 * This is not recommended in a production setting if you are
	 * returning sensitive data.
	 */
	public function __construct()
	{
		parent::__construct();
		$this->isRestrictedAccessModeEnabled = false;
	}

	/**
	 * @param Request $request
	 * @return DataTable
	 */
	public function & getDataTable(Request $request)
	{
		return $this->dataTable;
	}

	public function setDataTable(DataTable $dataTable) {
		$this->dataTable = $dataTable;
	}
}
@section('content')
<div class="fuelux">
  <table id="MyGrid" class="table table-bordered datagrid">
    <thead>
      <tr>
        <th>
          <span class="datagrid-header-title">Geographic Data Sample</span>
          <div class="datagrid-header-left">
            <div class="input-append search datagrid-search">
              <input type="text" class="input-medium" placeholder="Search">
              <button class="btn"><i class="icon-search"></i></button>
            </div>
          </div>
          <div class="datagrid-header-right">
            <div class="select filter">
              <button data-toggle="dropdown" class="btn dropdown-toggle">
                <span class="dropdown-label"></span>
                <span class="caret"></span>
              </button>
                <ul class="dropdown-menu">
                  <li data-value="all" data-selected="true"><a href="#">All</a></li>
                  <li data-value="lt5m"><a href="#">Population &lt; 5M</a></li>
                  <li data-value="gte5m"><a href="#">Population &gt;= 5M</a></li>
                </ul>
            </div>
          </div>
        </th>
      </tr>
    </thead>
    
    <tfoot>
      <tr>
        <th>
          <div class="datagrid-footer-left" style="display:none;">
            <div class="grid-controls">
              <span>
                <span class="grid-start"></span> -
                <span class="grid-end"></span> of
                <span class="grid-count"></span>
              </span>
              <div class="select grid-pagesize" data-resize="auto">
                <button data-toggle="dropdown" class="btn dropdown-toggle">
                  <span class="dropdown-label"></span>
                  <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                  <li data-value="5"><a href="#">5</a></li>
                  <li data-value="10" data-selected="true"><a href="#">10</a></li>
                  <li data-value="20"><a href="#">20</a></li>
                  <li data-value="50"><a href="#">50</a></li>
                  <li data-value="100"><a href="#">100</a></li>
                </ul>
              </div>
              <span>Per Page</span>
            </div>
          </div>
          <div class="datagrid-footer-right" style="display:none;">
            <div class="grid-pager">
              <button type="button" class="btn grid-prevpage"><i class="icon-chevron-left"></i></button>
              <span>Page</span>
              
              <div class="input-append dropdown combobox">
                <input class="span1" type="text">
                <button class="btn" data-toggle="dropdown"><i class="caret"></i></button>
                <ul class="dropdown-menu"></ul>
              </div>
              <span>of <span class="grid-pages"></span></span>
              <button type="button" class="btn grid-nextpage"><i class="icon-chevron-right"></i></button>
            </div>
          </div>
        </th>
      </tr>
    </tfoot>
  </table>
</div>
<script>
  var DataSource = function (options) {
  	this._formatter = options.formatter;
  	this._columns = options.columns;
  	this._data = options.data;
  	this._delay = options.delay || 0;
  };

DataSource.prototype = {
	
	columns: function () {
		return this._columns;
	},

	data: function (options, callback) {

		var self = this;

		setTimeout(function () {
		
        	var data = $.extend(true, [], self._data);
          
          console.log(options);
      
          // SEARCHING
          if (options.search) {
            data = _.filter(data, function (item) {
              for (var prop in item) {
                if (!item.hasOwnProperty(prop)) continue;
                if (~item[prop].toString().toLowerCase().indexOf(options.search.toLowerCase())) return true;
              }
              return false;
            });
          }
          var count = data.length;
  
          // SORTING
          if (options.sortProperty) {
            data = _.sortBy(data, options.sortProperty);
            if (options.sortDirection === 'desc') data.reverse();
          }
          
          // PAGING
          var startIndex = options.pageIndex * options.pageSize;
          var endIndex = startIndex + options.pageSize;
          var end = (endIndex > count) ? count : endIndex;
          var pages = Math.ceil(count / options.pageSize);
          var page = options.pageIndex + 1;
          var start = startIndex + 1;
          
          data = data.slice(startIndex, endIndex);
          
          if (self._formatter) self._formatter(data);
          
          callback({ data: data, start: start, end: end, count: count, pages: pages, page: page });
        
      	}, this._delay);  
	}
};

// INITIALIZING THE DATAGRID
var dataSource = new DataSource({
  columns: [
    {
      property: 'name',
      label: 'Name',
      sortable: true
    },
    {
      property: 'countrycode',
      label: 'Country',
      sortable: true
    },
    {
      property: 'population',
      label: 'Population',
      sortable: true
    },
    {
      property: 'fcodeName',
      label: 'Type',
      sortable: true
    }
  ],
  data: [
    {name:'foo', countrycode:'United States', population:423459000, fcodeName:'23434123' },
    {name:'boo', countrycode:'Canada', population:123459000, fcodeName:'552432123' },
    {name:'bar', countrycode:'United Kingdom', population:523459000, fcodeName:'54544123' },
    {name:'doo', countrycode:'France', population:323459050, fcodeName:'9848823123' },
    {name:'too', countrycode:'Scotland', population:42344300, fcodeName:'23434123' },
    {name:'woo', countrycode:'Ireland', population:12345903, fcodeName:'52432123' },
    {name:'mar', countrycode:'Austria', population:32342910, fcodeName:'4544123' },
    {name:'soo', countrycode:'Spain', population:23459900, fcodeName:'9848823123' },
    {name:"Dhaka",countrycode:"BD",population:10356500, fcodeName:'1848823123'},
    {name:"Jakarta",countrycode:"BD",population:10356500, fcodeName:'1848823123'},
    {name:"Seoul",countrycode:"ID",population:8540121, fcodeName:'4448828694'},
    {name:"Hong Kong",countrycode:"HK",population:18540121, fcodeName:'349903004'}
  ],
  delay:300
});

$('#MyGrid').datagrid({
  dataSource: dataSource,
  stretchHeight: true
});

$('#datagrid-reload').on('click', function () {
  $('#MyGrid').datagrid('reload');
});

</script>
@stop

@section('aside')
	@parent
@stop
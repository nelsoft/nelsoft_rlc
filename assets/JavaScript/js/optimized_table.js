// JavaScript Document

/**
 * For optimized table
 * @param [string]  selectedTableName  {selected table name}
 * @param [object]  options            {list of options. e.g. ({limit: int, rowStart: int, searchTable: function})}
 */
function optimizedTable(selectedTableName, options = {})
{
    this.tableName = selectedTableName;
    this.options = options;
    this.buttonPrevious = "#"+ this.tableName +"_btnprevious";
    this.buttonNext = "#"+ this.tableName +"_btnnext";
    this.textPageNumber = "#"+ this.tableName +"_txtpagenumber";
    this.divLastPage = "#"+ this.tableName +"_divlastpage";
    this.textFilterNumber = "#"+ this.tableName +"_txtfilternumber";
    this.defaultLimit = (options.limit) ? options.limit : 10;
    this.defaultRowStart = (options.rowStart) ? options.rowStart : 1;

    if (options.limit === undefined) {
        console.error("options.limit is required.");
        return;
    }
    this.currentLimit = parseInt(options.limit);

    if (options.rowStart === undefined) {
        console.error("options.rowStart is required.");
        return;
    }
    this.currentRowStart = parseInt(options.rowStart);
    this.rowCount = (options.rowCount == undefined) ? 0 : parseInt(options.rowCount);

    $(this.buttonPrevious).die("click");
    $(this.buttonNext).die("click");
    $(this.textPageNumber).die("keypress");
    $(this.textFilterNumber).die("keypress");

    this.getLimitValue = getLimit;
    this.setPageCount = setPageCount;
    this.doPreviousNext = doPreviousNext;
    this.doSearchTable = doSearchTable;
    this.addNew = doAddNew;
    this.deleteRow = doDeleteRow;

    var thisElement = this;

    $(this.buttonPrevious).unbind("click").click(function()
    {
        thisElement.doPreviousNext("previous");
    });

    $(this.buttonNext).unbind("click").click(function()
    {
        thisElement.doPreviousNext("next");
    });

    $(this.textPageNumber).unbind("keypress").keypress(function(event)
    {
        if (event.which == 8 || event.which == 13 || event.which > 47 && event.which < 58) {
            if (event.keyCode == 13) {
                let isContinue = true;
                rowStart = parseInt($(this).val());

                if (rowStart < 1) {
                    alert("Invalid page number!");
                    $(this).val(thisElement.currentRowStart);
                    isContinue = false;
                }

                if (rowStart > parseInt($(thisElement.divLastPage).html().trim())) {
                    alert("Invalid page number!");
                    $(this).val(thisElement.currentRowStart);
                    isContinue = false;
                }

                if (isContinue) {
                    thisElement.doSearchTable(rowStart);
                }
            }
        } else {
            event.preventDefault();
        }
    });

    $(this.textFilterNumber).unbind("keypress").keypress(function(event)
    {
        if (event.which == 8 || event.which == 13 || event.which > 47 && event.which < 58) {
            if (event.keyCode == 13) {
                if (typeof thisElement.options.searchTable === "function" && thisElement.options.searchTable) {
                    thisElement.options.searchTable(0);
                } else {
                    console.error("There's no setup for seachTable or searchTable is not a function.")
                }
            }
        } else {
            event.preventDefault();
        }
    });
}

/**
 * Do previous or next process
 * @param [string]  job  {Selected job. e.g. ("next", "previous")}
 */
function doPreviousNext(job)
{
    let isContinue = true;
    let rowStart = parseInt(this.currentRowStart);
    let currentPage = parseInt($(this.textPageNumber).val());
    let lastPage = parseInt($(this.divLastPage).html().trim());
    let isAllowShowPrompt = (currentPage == rowStart) ? false : true;
    rowStart = (job == "next") ? rowStart + 1 : rowStart - 1;

    if ((currentPage < 1 && job == "previous") || (currentPage > lastPage && job == "next")) {
        rowStart = currentPage;
        isAllowShowPrompt = true;
    }

    if (currentPage < 1 && job == "next") {
        rowStart = 1;
    }

    if (currentPage > lastPage && job == "previous") {
        rowStart = lastPage;
    }

    if (rowStart < 1) {
        isContinue = false;
    }

    if (rowStart > lastPage) {
        isContinue = false;
    }

    if (isContinue) {
        this.doSearchTable(rowStart);
    } else {
        if (isAllowShowPrompt) {
            alert("Invalid page number!");
        }
    }
}

/**
 * Do search table process
 * @param [int]     rowStart  {row start}
 * @param [bolean]  isAdd     {is  Add new}
 */
function doSearchTable(rowStart, isAdd = false)
{
    let limit = $(this.textFilterNumber).val();
    $(this.textPageNumber).val(rowStart);

    rowStart = rowStart * parseInt(limit);
    rowStart = rowStart - parseInt(limit);
    if (typeof this.options.searchTable === "function" && this.options.searchTable) {
        this.options.searchTable(rowStart, isAdd);
    } else {
        console.error("There's no setup for seachTable or searchTable is not a function.")
    }
}

/**
 * Get table limit
 */
function getLimit()
{
    return ($(this.textFilterNumber).val() === undefined) ? this.defaultLimit : $(this.textFilterNumber).val();
}

/**
 * To set new page count
 * @param [string]  rowCount  {total count of row in table}
 */
function setPageCount(rowCount)
{
    let limit = this.getLimitValue();
    let pageCount = parseInt(rowCount / parseInt(limit));
    pageCount = (rowCount % limit) ? (pageCount + 1) : pageCount;

    $(this.divLastPage).html(pageCount);
}

/**
 * do add new row
 */
function doAddNew()
{
    let newRowCount = this.rowCount + 1;
    this.setPageCount(newRowCount);

    let lastPage = parseInt($(this.divLastPage).html().trim());
    this.doSearchTable(lastPage, true);
}

/**
 * do delete row
 * @param [int]     rowStart  {row start}
 */
function doDeleteRow(rowStart)
{
    let newRowCount = this.rowCount - 1;
    this.setPageCount(newRowCount);

    let lastPage = parseInt($(this.divLastPage).html().trim());
    rowStart = (rowStart > lastPage) ? lastPage : rowStart;
    this.doSearchTable(rowStart);
}

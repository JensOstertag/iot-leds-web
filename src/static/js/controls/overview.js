export const init = (translations) => {
    let tableElement = document.querySelector("#controls-table");
    const table = new DataTable(tableElement, {
        layout: {
            topStart: "search",
            topEnd: null,
            bottomStart: "paging",
            bottomEnd: null
        },
        language: {
            sSearch: "",
            sSearchPlaceholder: translations["Search..."],
            sZeroRecords: translations["No entries"],
            emptyTable: translations["No entries"],
            oPaginate: {
                sPrevious: translations["Back"],
                sNext: translations["Next"]
            },
            loadingRecords: translations["Loading..."]
        },
        pagingType: "simple_numbers",
        order: [[1, "asc"]],
        ajax: {
            url: tableElement.getAttribute("data-table-ajax"),
            dataSrc: "",
            type: "POST"
        },
        autoWidth: false,
        columns: [
            { data: "name" }
        ]
    });

    const search = document.querySelector("#controls-table_wrapper .dt-search input");
    search.setAttribute("type", "text");

    document.querySelector("#controls-table tbody").addEventListener("click", (event) => {
        const clickedRow = event.target.closest("tr");
        if(clickedRow) {
            window.location.href = table.row(clickedRow).data().editHref;
        }
    });
}

export default { init };

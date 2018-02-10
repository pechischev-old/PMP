class SeasonsView {
    constructor() {
        this._seasonCount = 1;
    }

    /**
     * @returns {Element}
     */
    createSeasonView() {
        const seasonBlock = this._createElement("form-horizontal season-info col-md-12 not-left-indent");

        this._createElement("season-info__icon", seasonBlock);


        const table = new TableView();

        const form = this._createElement("form-horizontal col-md-9");
        const formGroup1 = this._createElement("form-group", form);
        const col1 = this._createElement("col-md-6", formGroup1);
        col1.innerHTML = `<label class="season-info__title">Название</label>
                    ${this._createInputField("seasonTitle" + this._seasonCount).outerHTML}`;

        const formGroup2 = this._createElement("form-group", form);
        const col2 = this._createElement("col-md-6", formGroup2);
        col2.innerHTML = '<label class="season-info__count">Кол-во серий</label>';

        const seriesElement = this._createInputField("seriesCount" + this._seasonCount);
        seriesElement.addEventListener("change", () => {
            table.createRows(seriesElement.value);
            $(window).resize();
        });
        col2.appendChild(seriesElement);
        this._seasonCount++;

        seasonBlock.appendChild(form);

        const col3 = this._createElement("col-md-8", seasonBlock);
        col3.appendChild(table.container());
        return seasonBlock;
    }

    _createElement(classNames, parentElement) {
        const element = document.createElement("div");
        element.setAttribute("class", classNames);
        if (parentElement)
        {
            parentElement.appendChild(element);
        }
        return element;
    }

    /**
     * @param {string} name
     * @returns {Element}
     * @private
     */
    _createInputField(name) {
        const input = document.createElement("input");
        input.setAttribute("type", "text");
        input.setAttribute("class", "form-control");
        input.setAttribute("name", name);
        return input;
    }
}

class TableView {
    constructor() {
        this._tbody = null;

        this._table = this._createTable();
    }

    container() {
        return this._table;
    }

    createRows(count) {
        while(this._tbody.firstChild)
        {
            this._tbody.removeChild(this._tbody.firstChild);
        }
        for (let i = 1; i <= count; ++i)
        {
            this._tbody.appendChild(this._createRow(i));
        }
    }

    _createRow(i) {
        const tr = document.createElement("tr");
        this._createColumn(i, tr);
        const column = this._createColumn('', tr);
        this._createColumn('', tr);

        const input = document.createElement("input");
        input.setAttribute("class", "empty-input");
        column.appendChild(input);
        return tr;
    }

    _createTable() {
        const table = document.createElement("table");
        table.setAttribute("class", "table table-condensed");

        const thead = document.createElement("thead");
        table.appendChild(thead);
        const tr = document.createElement("tr");
        thead.appendChild(tr);

        this._createColumn("#", tr);
        this._createColumn("Название", tr);
        this._createColumn("Путь к изображению", tr);

        this._tbody = document.createElement("tbody");
        table.appendChild(this._tbody);
        return table;
    }

    _createColumn(value, parent) {
        const column = document.createElement("th");
        column.textContent = value;
        parent.appendChild(column);
        return column;
    }
}

$(document).ready(() => {

   const seasonView = new SeasonsView();

    $(".add-button").click((event) => {
        const element = $(".add-button").get(0);
        const parentDiv = element.parentNode;

        parentDiv.insertBefore(seasonView.createSeasonView(), element);
        $(window).resize();
    });
});
<%@ Page Title="" Language="C#" MasterPageFile="~/Areas/aspx/Views/Shared/Web.Master" 
Inherits="System.Web.Mvc.ViewPage<IEnumerable<Kendo.Mvc.Examples.Models.ProductViewModel>>" %>

<asp:Content ContentPlaceHolderID="MainContent" runat="server">

<div class="k-rtl">

<div class="k-toolbar k-grid-toolbar">
    <a class="k-button k-button-icontext k-add-button" href="#"><span class="k-icon k-add"></span>Add new record</a>
</div>

<script id="list-view-template" type="text/x-kendo-template">
    <div class="product-view">
            <dl>
                <dt>Product Name</dt>
                <dd>${ProductName}</dd>
                <dt>Unit Price</dt>
                <dd>${kendo.toString(UnitPrice, "c")}</dd>
                <dt>Units In Stock</dt>
                <dd>${UnitsInStock}</dd>
                <dt>Discontinued</dt>
                <dd>${Discontinued}</dd>
            </dl>
            <div class="edit-buttons">
                <a class="k-button k-button-icontext k-edit-button" href="\\#"><span class="k-icon k-edit"></span>Edit</a>
                <a class="k-button k-button-icontext k-delete-button" href="\\#"><span class="k-icon k-delete"></span>Delete</a>
            </div>
        </div>
</script>

<%: Html.Kendo().ListView<Kendo.Mvc.Examples.Models.ProductViewModel>(Model)
    .Name("listView")
    .TagName("div")
    .ClientTemplateId("list-view-template")
    .DataSource(dataSource => dataSource
        .Model(model => model.Id("ProductID"))
        .PageSize(6)
        .Create(create => create.Action("Editing_Create", "ListView"))
        .Read(read => read.Action("Editing_Read", "ListView"))
        .Update(update => update.Action("Editing_Update", "ListView"))
        .Destroy(destroy => destroy.Action("Editing_Destroy", "ListView"))
    )
    .Pageable()
    .Editable()
%>

</div>

<script>
    $(function() {
        var listView = $("#listView").data("kendoListView");

        $(".k-add-button").click(function(e) {
            listView.add();
            e.preventDefault();
        });
    });
</script>
<style scoped>
    .product-view
    {
        float: right;
        width: 320px;
        margin: 5px;
        padding: 3px;
        -moz-box-shadow: inset 0 0 50px rgba(0,0,0,0.1);
        -webkit-box-shadow: inset 0 0 50px rgba(0,0,0,0.1);
        box-shadow: inner 0 0 50px rgba(0,0,0,0.1);
        border-top: 1px solid rgba(0,0,0,0.1);
        -webkit-border-radius: 8px;
        -moz-border-radius: 8px;
        border-radius: 8px;
    }

    .product-view dl
    {
        margin: 10px 0;
        padding: 0;
        min-width: 0;
    }
    .product-view dt, dd
    {
        float: right;
        margin: 0;
        padding: 0;
        height: 30px;
        line-height: 30px;
    }
    .product-view dt
    {
        clear: right;
        padding: 0 15px 0 5px;
        text-align: left;
        opacity: 0.6;
        width: 100px;
    }
    .k-listview
    {
        border: 0;
        padding: 0;
        min-width: 0;
    }
    .k-listview:after, .product-view dl:after
    {
        content: ".";
        display: block;
        height: 0;
        clear: both;
        visibility: hidden;
    }
    .edit-buttons
    {
        text-align: left;
        padding: 5px;
        min-width: 100px;
        border-top: 1px solid rgba(0,0,0,0.1);
        -webkit-border-radius: 8px;
        -moz-border-radius: 8px;
        border-radius: 8px;
    }

    .k-toolbar, #listView, .k-pager-wrap
    {
        width: 660px;
        margin: 0 auto;
        -webkit-border-radius: 11px;
        -moz-border-radius: 11px;
        border-radius: 11px;s
    }
    #listView
    {
        width: 674px;
    }
    span.k-invalid-msg
    {
        position: absolute;
        margin-left: 160px;
    }
</style>
</asp:Content>

<%@ Page Title="" Language="C#" MasterPageFile="~/Areas/aspx/Views/Shared/Web.Master" %>

<asp:Content ContentPlaceHolderID="MainContent" runat="server">
    <%:Html.Kendo().Grid<Kendo.Mvc.Examples.Models.OrderViewModel>()    
        .Name("Grid")
        .Columns(columns => {
            columns.Bound(o => o.OrderID).Width(100);
            columns.Bound(o => o.ShipCountry).Width(180);        
            columns.Bound(o => o.ShipName);
            columns.Bound(o => o.OrderDate).Format("{0:d}").Width(120); 
        })    
        .Sortable()
        .Scrollable(scrollable => scrollable.Virtual(true).Height(280))    
        .DataSource(dataSource => dataSource
            .Ajax()
            .PageSize(100)
            .Read(read => read.Action("Virtualization_Read", "Grid"))
         )
    %>
</asp:Content>

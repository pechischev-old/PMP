$(document).ready(() => {

    const reload = () => location.reload();

    $("#reset").click(reload);

    $("#submit").click(() => {

        // TODO: отправлять корректные данные и вытаскивать ошибки, в случае ошибок выводить сообщение о невалидных данных

        const title = $("#title").val();
        const description = $("#description").val();
        const startYear = $("#start-year").val();
        const endYear = $("#end-year").val();
        const actors = $("#actors").val();
        const genries = $("#genries").val();

        const seasonsTitles = $("[name^='seasonTitle']").get();
        const seriesCounts = $("[name^='seriesCount']").get();

        const seasonsInfo = [];

        for (let i = 0, length = seasonsTitles.length; i < length; ++i)
        {
            const seasonTitle = seasonsTitles[i].value;
            const seriesCount = seriesCounts[i].value;

            seasonsInfo.push({seasonTitle, seriesCount});
        }


        const json = {
            title,
            description,
            startYear,
            endYear: endYear || null,
            actors,
            genries,
            seasonsInfo
        };

        $.post(location.href + "/action", json);
        reload();
    });
});
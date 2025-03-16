import autoComplete from "@tarekraafat/autocomplete.js";

window.addEventListener('load', function() {
    let partnerData = [];
    const autoCompleteJS = new autoComplete({
        selector: "#partner_search",
        placeHolder: "相手先を検索する",
        resultItem: {
            highlight: true,
        },
        data: {
            src: async (query) => {
                try{
                    const source = await fetch(`/api/searchPartners/?search=${query}`);
                    const data = await source.json();
                    partnerData = data;
                    return data.map((item) => item.name);
                } catch (error) {
                    console.log(error)
                    return [];
                }
          },
          cache: true,
        },
        resultsList: {
            element: (list,data) => {
                if (!data.results.length) {
                    const message = document.createElement("div");
                    message.setAttribute("class", "no_result");
                    message.innerHTML = `<span>該当する結果が見つかりませんでした: "${data.query}"</span>`;
                    list.prepend(message);
                }
            },
            noResults: true,
            id: "partner_list",
        },
        events: {
            input: {
              selection: (event) => {
                const selection = event.detail.selection.value;
                autoCompleteJS.input.value = selection;

                const selectedPartner = partnerData.find(partner => partner.name === selection);
                if (selectedPartner) {
                    document.getElementById('partner_id').value = selectedPartner.id;
                }
              }
            }
        },
    })

});

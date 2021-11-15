/* AJAX JQuery Code */

$(function() {

    /** Category Page */
    // Get rate items and sells Data for each cat
    $.ajax({  
        type: 'POST',  
        url: 'ajaxcharts.php', 
        data: { chart: "rateCatItemsSells", catid: document.getElementById('catid')?.value },
        success: function(response) {

            // console.log(JSON.parse(response))
            let responseOBJECT = JSON.parse(response)[0]
            //console.log(responseOBJECT.items)
            let dataToRateCatItemsY = (responseOBJECT.items).map(a => a.sumation).reverse();
            let dataToRateCatItemsX = (responseOBJECT.items).map(a => a.datetime).reverse();
            let dataToRateCatSellsY = (responseOBJECT.sells).map(a => a.sumation).reverse();
            let dataToRateCatSellsX = (responseOBJECT.sells).map(a => a.selldatetime).reverse();

            // console.info("ItemsX", dataToRateCatItemsX);
            // console.info("ItemsY", dataToRateCatItemsY);
            // console.info("SellsX", dataToRateCatSellsX);
            // console.info("SellsY", dataToRateCatSellsY);

            // Draw a Chart
            //  Line Chart To Show rate of items per time
            var rateItemsCatLineChart = document.getElementById('rateItemsCatLineChart').getContext('2d');
            var myRateItemsCatLineChart = new Chart(rateItemsCatLineChart, {
                type: 'line',
                data: {
                    labels: dataToRateCatItemsX,
                    datasets: [{
                        label: "Offered Items",
                        data: dataToRateCatItemsY,
                        backgroundColor: 'rgba(87, 87, 97, .5)',
                        borderColor: 'rgba(87, 87, 97)'
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }

            });
            // Draw a Chart
            //  Line Chart To Show rate of sells per time
            var rateSellsCatLineChart = document.getElementById('rateSellsCatLineChart').getContext('2d');
            var myRateSellsCatLineChart = new Chart(rateSellsCatLineChart, {
                type: 'line',
                data: {
                    labels: dataToRateCatSellsX,
                    datasets: [{
                        label: "Bought Items",
                        data: dataToRateCatSellsY,
                        backgroundColor: 'rgb(100, 131, 129, .5)',
                        borderColor: 'rgb(100, 131, 129)'
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }

            });
        }
    }).then(() => {
        /** Members Page */
        // Get rate items and sells Data for each user
        return $.ajax({  
            type: 'POST',  
            url: 'ajaxcharts.php', 
            data: { chart: "rateUserItemsSells", userid: document.getElementById('userid')?.value },
            success: function(response) {

                // console.log(JSON.parse(response))
                let responseOBJECT = JSON.parse(response)[0]
                //console.log(responseOBJECT.items)
                let dataToRateUserItemsY = (responseOBJECT.items).map(a => a.sumation).reverse();
                let dataToRateUserItemsX = (responseOBJECT.items).map(a => a.datetime).reverse();
                let dataToRateUserSellsY = (responseOBJECT.sells).map(a => a.sumation).reverse();
                let dataToRateUserSellsX = (responseOBJECT.sells).map(a => a.selldatetime).reverse();

                // console.info("ItemsX", dataToRateCatItemsX);
                // console.info("ItemsY", dataToRateCatItemsY);
                // console.info("SellsX", dataToRateCatSellsX);
                // console.info("SellsY", dataToRateCatSellsY);

                // Draw a Chart
                //  Line Chart To Show rate of items per time
                var rateItemsUserLineChart = document.getElementById('rateItemsUserLineChart').getContext('2d');
                var myrateItemsUserLineChart = new Chart(rateItemsUserLineChart, {
                    type: 'line',
                    data: {
                        labels: dataToRateUserItemsX,
                        datasets: [{
                            label: "Offered Items",
                            data: dataToRateUserItemsY,
                            backgroundColor: 'rgba(87, 87, 97, .5)',
                            borderColor: 'rgba(87, 87, 97)'
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }

                });
                // Draw a Chart
                //  Line Chart To Show rate of sells per time
                var rateItemsUserLineChart = document.getElementById('rateSellsUserLineChart').getContext('2d');
                var myrateItemsUserLineChart = new Chart(rateItemsUserLineChart, {
                    type: 'line',
                    data: {
                        labels: dataToRateUserSellsX,
                        datasets: [{
                            label: "Bought Items",
                            data: dataToRateUserSellsY,
                            backgroundColor: 'rgb(100, 131, 129, .5)',
                            borderColor: 'rgb(100, 131, 129)'
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }

                });
            }
        })
    }).then(() => {
        // DashBoard Page
        // Get rate items and sells Data
        return $.ajax({  
            type: 'POST',  
            url: 'ajaxcharts.php', 
            data: { chart: "rateItemsSells" },
            success: function(response) {
                // console.log(JSON.parse(response))
                let responseOBJECT = JSON.parse(response)[0]
                //console.log(responseOBJECT.items)
                let dataToRateItemsY = (responseOBJECT.items).map(a => a.sumation).reverse();;
                let dataToRateItemsX = (responseOBJECT.items).map(a => a.datetime).reverse();;
                let dataToRateSellsY = (responseOBJECT.sells).map(a => a.sumation).reverse();;
                let dataToRateSellsX = (responseOBJECT.sells).map(a => a.selldatetime).reverse();;
                
                // console.info("ItemsX", dataToRateItemsX);
                // console.info("ItemsY", dataToRateItemsY);
                // console.info("SellsX", dataToRateSellsX);
                // console.info("SellsY", dataToRateSellsY);
                
                // Draw a Chart
                //  Line Chart To Show rate of items per time
                var rateItemsLineChart = document.getElementById('rateItemsLineChart').getContext('2d');
                var myRateItemsLineChart = new Chart(rateItemsLineChart, {
                    type: 'line',
                    data: {
                        labels: dataToRateItemsX,
                        datasets: [{
                            label: "Offered Items",
                            data: dataToRateItemsY,
                            backgroundColor: 'rgba(87, 87, 97, .5)',
                            borderColor: 'rgba(87, 87, 97)'
                        }],
                        
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
    
                });
                // Draw a Chart
                //  Line Chart To Show rate of sells per time
                var rateSellsLineChart = document.getElementById('rateSellsLineChart').getContext('2d');
                var myRateSellsLineChart = new Chart(rateSellsLineChart, {
                    type: 'line',
                    data: {
                        labels: dataToRateSellsX,
                        datasets: [{
                            label: "Bought Items",
                            data: dataToRateSellsY,
                            backgroundColor: 'rgb(100, 131, 129, .5)',
                            borderColor: 'rgb(100, 131, 129)'
                        }],
                        
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
    
                });
            }
        });
    }).then(()=> {
        // GET TOP 5 user items Chart Data
        return $.ajax({  
            type: 'POST',  
            url: 'ajaxcharts.php', 
            data: { chart: "top5UserItems" },
            success: function(response) {

                // console.info("sdfsdfsff", response)
                let dataTotop5UserItemsY = JSON.parse(response).map(a => a.sumation);
                let dataTotop5UserItemsX = JSON.parse(response).map(a => a.username);
                // console.info("sdfsdfsff", dataTotop5UserItemsX)
                // Draw a Chart
                // Column Bar To Show Top 5 users offer items
                var top5UserItemsBarChart = document.getElementById('top5UserItemsBarChart').getContext('2d');
                var myTop5UserItemsBarChart = new Chart(top5UserItemsBarChart, {
                    type: 'bar',
                    data: {
                        labels: dataTotop5UserItemsX,
                        datasets: [{
                            label: 'Offered Items',
                            data: dataTotop5UserItemsY,
                            backgroundColor: [
                                
                                'rgb(87, 87, 97)',
                                'rgb(100, 131, 129)',
                                'rgb(138, 203, 136)',
                                'rgb(213, 176, 172)',
                                'rgb(255, 191, 70)',
                            ],
                            borderColor: [
                                
                                'rgb(87, 87, 97)',
                                'rgb(100, 131, 129)',
                                'rgb(138, 203, 136)',
                                'rgb(213, 176, 172)',
                                'rgb(255, 191, 70)',
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
                });
            }
            
        }); 
    }).then(()=> {
        // GET TOP 5 user sells Chart Data

        return $.ajax({  
            type: 'POST',  
            url: 'ajaxcharts.php', 
            data: { chart: "top5UserSells" },
            success: function(response) {
                //console.log(response)
                // JSON.parse(response).forEach(element => {
                //     element['avatar'] = btoa(element['avatar'])
                // });
                let dataTotop5UserSellsY = JSON.parse(response).map(a => a.sumation);
                let dataTotop5UserSellsX = JSON.parse(response).map(a => a.username);
                // Column Bar To Show Top 5 users offer items
                var top5UserSellsBarChart = document.getElementById('top5UserSellsBarChart').getContext('2d');
                var myTop5UserSellsBarChart = new Chart(top5UserSellsBarChart, {
                    type: 'bar',
                    data: {
                        labels: dataTotop5UserSellsX,
                        datasets: [{
                            label: 'Bought Items',
                            data: dataTotop5UserSellsY,
                            backgroundColor: [
                                
                                'rgb(87, 87, 97)',
                                'rgb(100, 131, 129)',
                                'rgb(138, 203, 136)',
                                'rgb(213, 176, 172)',
                                'rgb(255, 191, 70)',
                            ],
                            borderColor: [
                                
                                'rgb(87, 87, 97)',
                                'rgb(100, 131, 129)',
                                'rgb(138, 203, 136)',
                                'rgb(213, 176, 172)',
                                'rgb(255, 191, 70)',
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
                });
            }
        });
    }).then(()=> {
        // GET TOP 5 user items Chart Data per cat
        return $.ajax({  
            type: 'POST',  
            url: 'ajaxcharts.php', 
            data: { chart: "top5UserItemsCat", catid: document.getElementById('catid')?.value },
            success: function(response) {

                // console.info("sdfsdfsff", response)
                let dataTotop5UserItemsCatY = JSON.parse(response).map(a => a.sumation);
                let dataTotop5UserItemsCatX = JSON.parse(response).map(a => a.username);
                // console.info("sdfsdfsff", dataTotop5UserItemsX)
                // Draw a Chart
                // Column Bar To Show Top 5 users offer items
                var top5UserItemsBarChartCat = document.getElementById('top5UserItemsBarChartCat').getContext('2d');
                var myTop5UserItemsBarChartCat = new Chart(top5UserItemsBarChartCat, {
                    type: 'bar',
                    data: {
                        labels: dataTotop5UserItemsCatX,
                        datasets: [{
                            label: 'Offered Items',
                            data: dataTotop5UserItemsCatY,
                            backgroundColor: [
                                
                                'rgb(87, 87, 97)',
                                'rgb(100, 131, 129)',
                                'rgb(138, 203, 136)',
                                'rgb(213, 176, 172)',
                                'rgb(255, 191, 70)',
                            ],
                            borderColor: [
                                
                                'rgb(87, 87, 97)',
                                'rgb(100, 131, 129)',
                                'rgb(138, 203, 136)',
                                'rgb(213, 176, 172)',
                                'rgb(255, 191, 70)',
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
                });
            }
            
        }); 
    }).then(()=> {
        // GET TOP 5 user sells Chart Data per cat

        return $.ajax({  
            type: 'POST',  
            url: 'ajaxcharts.php', 
            data: { chart: "top5UserSellsCat", catid: document.getElementById('catid')?.value  },
            success: function(response) {
                //console.log(response)
                // JSON.parse(response).forEach(element => {
                //     element['avatar'] = btoa(element['avatar'])
                // });
                let dataTotop5UserSellsCatY = JSON.parse(response).map(a => a.sumation);
                let dataTotop5UserSellsCatX = JSON.parse(response).map(a => a.username);
                // Column Bar To Show Top 5 users offer items
                var top5UserSellsBarChartCat = document.getElementById('top5UserSellsBarChartCat').getContext('2d');
                var myTop5UserSellsBarChartCat = new Chart(top5UserSellsBarChartCat, {
                    type: 'bar',
                    data: {
                        labels: dataTotop5UserSellsCatX,
                        datasets: [{
                            label: 'Bought Items',
                            data: dataTotop5UserSellsCatY,
                            backgroundColor: [
                                
                                'rgb(87, 87, 97)',
                                'rgb(100, 131, 129)',
                                'rgb(138, 203, 136)',
                                'rgb(213, 176, 172)',
                                'rgb(255, 191, 70)',
                            ],
                            borderColor: [
                                
                                'rgb(87, 87, 97)',
                                'rgb(100, 131, 129)',
                                'rgb(138, 203, 136)',
                                'rgb(213, 176, 172)',
                                'rgb(255, 191, 70)',
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
                });
            }
        });
    }).then(()=> {
        // GET TOP 5 user items Chart Data per user
        return $.ajax({  
            type: 'POST',  
            url: 'ajaxcharts.php', 
            data: { chart: "top5CatItemsUser", userid: document.getElementById('userid')?.value },
            success: function(response) {

                // console.info("sdfsdfsff", response)
                let dataTotop5CatItemsUserY = JSON.parse(response).map(a => a.sumation);
                let dataTotop5CatItemsUserX = JSON.parse(response).map(a => a.name);
                // console.info("sdfsdfsff", dataTotop5UserItemsX)
                // Draw a Chart
                // Column Bar To Show Top 5 users offer items
                var top5CatItemsBarChartUser = document.getElementById('top5CatItemsBarChartUser').getContext('2d');
                var mytop5CatItemsBarChartUser = new Chart(top5CatItemsBarChartUser, {
                    type: 'bar',
                    data: {
                        labels: dataTotop5CatItemsUserX,
                        datasets: [{
                            label: 'Offered Items',
                            data: dataTotop5CatItemsUserY,
                            backgroundColor: [
                                
                                'rgb(87, 87, 97)',
                                'rgb(100, 131, 129)',
                                'rgb(138, 203, 136)',
                                'rgb(213, 176, 172)',
                                'rgb(255, 191, 70)',
                            ],
                            borderColor: [
                                
                                'rgb(87, 87, 97)',
                                'rgb(100, 131, 129)',
                                'rgb(138, 203, 136)',
                                'rgb(213, 176, 172)',
                                'rgb(255, 191, 70)',
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
                });
            }
            
        }); 
    }).then(()=> {
        // GET TOP 5 user sells Chart Data per user

        return $.ajax({  
            type: 'POST',  
            url: 'ajaxcharts.php', 
            data: { chart: "top5CatSellsUser", userid: document.getElementById('userid')?.value  },
            success: function(response) {
                //console.log(response)
                // JSON.parse(response).forEach(element => {
                //     element['avatar'] = btoa(element['avatar'])
                // });
                let dataTotop5CatSellsUserY = JSON.parse(response).map(a => a.sumation);
                let dataTotop5CatSellsUserX = JSON.parse(response).map(a => a.name);
                // Column Bar To Show Top 5 users offer items
                var top5CatSellsBarChartUser = document.getElementById('top5CatSellsBarChartUser').getContext('2d');
                var mytop5CatSellsBarChartUser = new Chart(top5CatSellsBarChartUser, {
                    type: 'bar',
                    data: {
                        labels: dataTotop5CatSellsUserX,
                        datasets: [{
                            label: 'Bought Items',
                            data: dataTotop5CatSellsUserY,
                            backgroundColor: [
                                
                                'rgb(87, 87, 97)',
                                'rgb(100, 131, 129)',
                                'rgb(138, 203, 136)',
                                'rgb(213, 176, 172)',
                                'rgb(255, 191, 70)',
                            ],
                            borderColor: [
                                
                                'rgb(87, 87, 97)',
                                'rgb(100, 131, 129)',
                                'rgb(138, 203, 136)',
                                'rgb(213, 176, 172)',
                                'rgb(255, 191, 70)',
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
                });
            }
        });
    }).then(() => {
        // GET TOP 5 cat items Chart Data
        return $.ajax({  
            type: 'POST',  
            url: 'ajaxcharts.php', 
            data: { chart: "top5CatItems" },
            success: function(response) {
                let dataTotop5CatItemsY = JSON.parse(response).map(a => a.sumation);
                let dataTotop5CatItemsX = JSON.parse(response).map(a => a.name);
                // Draw a Chart
                // Column Bar To Show Top 5 users offer items
                var top5CatItemsBarChart = document.getElementById('top5CatItemsBarChart').getContext('2d');
                var myTop5CatItemsBarChart = new Chart(top5CatItemsBarChart, {
                    type: 'bar',
                    data: {
                        labels: dataTotop5CatItemsX,
                        datasets: [{
                            label: 'Offered Items',
                            data: dataTotop5CatItemsY,
                            backgroundColor: [
                                
                                'rgb(87, 87, 97)',
                                'rgb(100, 131, 129)',
                                'rgb(138, 203, 136)',
                                'rgb(213, 176, 172)',
                                'rgb(255, 191, 70)',
                            ],
                            borderColor: [
                                
                                'rgb(87, 87, 97)',
                                'rgb(100, 131, 129)',
                                'rgb(138, 203, 136)',
                                'rgb(213, 176, 172)',
                                'rgb(255, 191, 70)',
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
                });
            }
            
        });   
    }).then(() => {
        // GET TOP 5 cat sells Chart Data

        return $.ajax({  
            type: 'POST',  
            url: 'ajaxcharts.php', 
            data: { chart: "top5CatSells" },
            success: function(response) {
                //console.log(response)
                let dataTotop5CatSellsY = JSON.parse(response).map(a => a.sumation);
                let dataTotop5CatSellsX = JSON.parse(response).map(a => a.name);
                // Column Bar To Show Top 5 users offer items
                var top5CatSellsBarChart = document.getElementById('top5CatSellsBarChart').getContext('2d');
                var myTop5CatSellsBarChart = new Chart(top5CatSellsBarChart, {
                    type: 'bar',
                    data: {
                        labels: dataTotop5CatSellsX,
                        datasets: [{
                            label: 'Bought Items',
                            data: dataTotop5CatSellsY,
                            backgroundColor: [
                                
                                'rgb(87, 87, 97)',
                                'rgb(100, 131, 129)',
                                'rgb(138, 203, 136)',
                                'rgb(213, 176, 172)',
                                'rgb(255, 191, 70)',
                            ],
                            borderColor: [
                                
                                'rgb(87, 87, 97)',
                                'rgb(100, 131, 129)',
                                'rgb(138, 203, 136)',
                                'rgb(213, 176, 172)',
                                'rgb(255, 191, 70)',
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
                });
            }
        });
    })


    // WITHOUT AJAX Draw Pie Charts 

    // Pie Chart to show status ratio in items
    var statusItemsPieChart = document.getElementById('statusItemsPieChart').getContext('2d');
    var myStatusItemsPieChart = new Chart(statusItemsPieChart, {
        type: 'pie',
        data: {
            labels: ['New', 'Like New', 'Old'],
            datasets: [{
                label: '# of Votes',
                data: [document.getElementById('newItemsCount').value, document.getElementById('likeNewItemsCount').value, document.getElementById('oldItemsCount').value],
                backgroundColor: [
                    'rgb(138, 203, 136)',
                    'rgb(255, 191, 70)',
                    'rgb(87, 87, 97)'
                ],
                borderColor: [
                    'rgb(138, 203, 136)',
                    'rgb(255, 191, 70)',
                    'rgb(87, 87, 97)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });


    // Pie Chart to show status ratio in sells
    var statusSellsPieChart = document.getElementById('statusSellsPieChart').getContext('2d');
    var myStatusSellsPieChart = new Chart(statusSellsPieChart, {
        type: 'pie',
        data: {
            labels: ['New', 'Like New', 'Old'],
            datasets: [{
                label: '# of Votes',
                data: [document.getElementById('newSellsCount').value, document.getElementById('likeNewSellsCount').value, document.getElementById('oldSellsCount').value],
                backgroundColor: [
                    'rgb(138, 203, 136)',
                    'rgb(255, 191, 70)',
                    'rgb(87, 87, 97)'
                ],
                borderColor: [
                    'rgb(138, 203, 136)',
                    'rgb(255, 191, 70)',
                    'rgb(87, 87, 97)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
    /*
    // Pie Chart to show status ratio in items per cat
    var statusItemsPieChartCat = document.getElementById('statusItemsPieChartCat').getContext('2d');
    var myStatusItemsPieChartCat = new Chart(
        Cat, {
        type: 'pie',
        data: {
            labels: ['New', 'Like New', 'Old'],
            datasets: [{
                label: '# of Votes',
                data: [document.getElementById('newItemsCountCat').value, document.getElementById('likeNewItemsCountCat').value, document.getElementById('oldItemsCountCat').value],
                backgroundColor: [
                    'rgb(138, 203, 136)',
                    'rgb(255, 191, 70)',
                    'rgb(87, 87, 97)'
                ],
                borderColor: [
                    'rgb(138, 203, 136)',
                    'rgb(255, 191, 70)',
                    'rgb(87, 87, 97)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });


    // Pie Chart to show status ratio in sells per cat
    var statusSellsPieChartCat = document.getElementById('statusSellsPieChartCat').getContext('2d');
    var myStatusSellsPieChartCat = new Chart(statusSellsPieChartCat, {
        type: 'pie',
        data: {
            labels: ['New', 'Like New', 'Old'],
            datasets: [{
                label: '# of Votes',
                data: [document.getElementById('newSellsCountCat').value, document.getElementById('likeNewSellsCountCat').value, document.getElementById('oldSellsCountCat').value],
                backgroundColor: [
                    'rgb(138, 203, 136)',
                    'rgb(255, 191, 70)',
                    'rgb(87, 87, 97)'
                ],
                borderColor: [
                    'rgb(138, 203, 136)',
                    'rgb(255, 191, 70)',
                    'rgb(87, 87, 97)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
*/
});

   






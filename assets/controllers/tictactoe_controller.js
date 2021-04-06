import { Controller } from 'stimulus';
const axios = require('axios').default;

export default class extends Controller {
    move({ target }) {
        if (document.querySelector('.gameover').classList.contains('active')) return;
        axios({
                method: 'post',
                data: {
                    xCoordinate: parseInt(this.element.getAttribute('data-x')),
                    yCoordinate: parseInt(this.element.getAttribute('data-y'))
                },
                headers: { 'Content-Type': 'application/json' },
                url: `${window.location.protocol}//${window.location.href.split("/")[2]}/move/${window.location.href.split("/")[4]??0}`,
            })
            .then(function(response) {
                target.innerText = 'X';
                if (response.data.gameResult) {
                    document.querySelector('.result').innerText = response.data.gameResult;
                    document.querySelector('.gameover').classList.add('active');
                }
                if (response.data.gameResult != 'You won.') {
                    document.querySelectorAll(`[data-y='${response.data.movesPC[1]}']`)[response.data.movesPC[0]].innerText = 'O';
                }
            })
            .catch(function(error) {
                console.log(error.response.data)
            });
    }

    replay() {
        let fields = document.querySelectorAll('[data-x]');
        for (let i = 0; i < fields.length; i++) {
            fields[i].innerText = '';
        }
        document.querySelector('.gameover').classList.remove('active');
    }

}
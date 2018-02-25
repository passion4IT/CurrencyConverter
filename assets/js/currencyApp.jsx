/**
 * CurrencyApp rendering Component
 * ReactJs
 * Author Amit Thakur @Thakuramit3@hotmail.com
 */

import React, { Component } from 'react'
import axios from 'axios'

class CurrencyApp extends Component {
    constructor(props) {
        super(props)
        this.state = {
            currencies: [],
            loading: true,
        }

        this.fetchNewValue = this.fetchNewValue.bind(this)
    }

    componentDidMount() {
        axios.get('/currencies')
        .then(response => this.setState({
            currencies: response.data,
            loading: false,
        }))
    }

    formatDate(date) {
        const dateObject = new Date(date)
        const year = dateObject.getFullYear()
        const month = dateObject.getMonth() + 1
        const day = dateObject.getDate()
        const time = `${dateObject.getHours()}:${dateObject.getMinutes()}:${dateObject.getSeconds()}`
        return `${day}.${month}.${year} ${time}`
    }

    fetchNewValue() {
        this.setState({ loading: true }, () => {
            axios.get('/currency/conversion')
            .then(response => this.setState({
                currencies: response.data,
                loading: false,
            }))
        })

    }

    render() {
        return (
            <div className="currencies-block">
                <h4 className="text-center text-uppercase text-primary">Currency Conversion</h4>
                {this.state.loading &&
                    <h5 className="text-info">Loading...</h5>
                }
                {this.state.currencies && !this.state.loading &&
                    <table className="table table-bordered">
                        <thead>
                            <tr className="text-info">
                                <th>Timestamp</th>
                                <th>EURO</th>
                                <th>USD</th>
                                <th>FRANC</th>
                            </tr>
                        </thead>
                        <tbody>
                            {Object.keys(this.state.currencies).map((uuid) => {
                                const currency = this.state.currencies[uuid]
                                return <tr className="text-primary" key={uuid}>
                                    <td>{this.formatDate(currency.timestamp.date)}</td>
                                    <td>{currency.euro}</td>
                                    <td>{currency.usd}</td>
                                    <td>{currency.franc}</td>
                                </tr>
                            })}
                        </tbody>
                    </table>
                }
                <button type="button" className="btn btn-primary" onClick={() => this.fetchNewValue()}>
                    Fetch New Rate
                </button>
            </div>
        )

    }
}

export default CurrencyApp

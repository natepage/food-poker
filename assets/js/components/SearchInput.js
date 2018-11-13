import React from 'react';
import PropTypes from 'prop-types';
import CircularProgress from '@material-ui/core/CircularProgress';
import List from '@material-ui/core/List';
import ListItem from '@material-ui/core/ListItem';
import ListItemText from '@material-ui/core/ListItemText';
import PlacesAutocomplete from 'react-places-autocomplete';
import compose from 'recompose/compose';
import { bindActionCreators } from 'redux';
import { connect } from 'react-redux';
import { selectSearchAddress } from './../redux/actions';
import { withStyles } from '@material-ui/core/styles';

class SearchInput extends React.Component
{
    constructor(props) {
        super(props);

        this.handleChange = this.handleChange.bind(this);
        this.handleSelect = this.handleSelect.bind(this);
    }

    handleChange(address) {
        this.props.selectSearchAddress({address: address});
    };
    handleSelect(address, placeId) {
        this.props.selectSearchAddress({address: address, placeId: placeId});
    };

    render() {
        const inputProps = {
            placeholder: 'Search Places ...',
            className: this.props.classes.input
        };

        return (
            <div className={this.props.classes.root}>
                <PlacesAutocomplete value={this.props.searchAddress} onChange={this.handleChange} onSelect={this.handleSelect}>
                    {({ getInputProps, suggestions, getSuggestionItemProps, loading }) => (
                        <div>
                            <input {...getInputProps(inputProps)} />
                            <div className={this.props.classes.suggestionsContainer} hidden={!loading && suggestions.length <= 0}>
                                {loading && suggestions.length <= 0 &&
                                    <div className={this.props.classes.loaderContainer}>
                                        <CircularProgress/>
                                    </div>
                                }
                                <List>
                                    {suggestions.map(suggestion => {
                                        return (
                                            <ListItem button {...getSuggestionItemProps(suggestion)}>
                                                <ListItemText primary={suggestion.description}/>
                                            </ListItem>
                                        );
                                    })}
                                </List>
                            </div>
                        </div>
                    )}
                </PlacesAutocomplete>
            </div>
        )
    }
}

const mapStateToProps = (store) => {
    return {
        searchAddress: store.state.searchAddress,
        searchPlaceId: store.state.searchPlaceId
    }
};

const mapDispatchToProps = (dispatch) => {
    return bindActionCreators({ selectSearchAddress }, dispatch);
};

const styles = theme => ({
    input: {
        border: 'none',
        borderRadius: 2,
        boxShadow: theme.shadows[2],
        fontSize: 16,
        outline: 'none',
        padding: 16,
        width: '100%'
    },
    loaderContainer: {
        display: 'flex',
        justifyContent: 'center'
    },
    root: {
        flexGrow: 1,
        fontFamily: theme.typography.fontFamily,
        position: 'relative'
    },
    suggestionsContainer: {
        boxShadow: theme.shadows[1],
        padding: 16,
        position: 'absolute',
        width: '100%',
        top: 55,
        zIndex: 5000
    }
});

SearchInput.propTypes = {
    classes: PropTypes.object.isRequired
};

export default compose(
    withStyles(styles),
    connect(mapStateToProps, mapDispatchToProps)
)(SearchInput);
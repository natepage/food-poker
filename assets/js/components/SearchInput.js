import React from 'react';
import PropTypes from 'prop-types';
import CircularProgress from '@material-ui/core/CircularProgress';
import List from '@material-ui/core/List';
import ListItem from '@material-ui/core/ListItem';
import ListItemText from '@material-ui/core/ListItemText';
import PlacesAutocomplete from 'react-places-autocomplete';
import { withStyles } from '@material-ui/core/styles';

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

class SearchInput extends React.Component
{
    constructor(props) {
        super(props);
        this.state = { address: '' };
        this.handleChange = this.handleChange.bind(this);
    }

    handleChange(address) {
        this.setState({ address });
    };

    render() {
        const inputProps = {
            placeholder: 'Search Places ...',
            className: this.props.classes.input
        };

        return (
            <div className={this.props.classes.root}>
                <PlacesAutocomplete value={this.state.address} onChange={this.handleChange} onSelect={this.handleSelect}>
                    {({ getInputProps, suggestions, getSuggestionItemProps, loading }) => (
                        <div>
                            <input {...getInputProps(inputProps)} />
                            <div className={this.props.classes.suggestionsContainer} hidden={!loading && suggestions.length <= 0 }>
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

SearchInput.propTypes = {
    classes: PropTypes.object.isRequired
};

export default withStyles(styles)(SearchInput);
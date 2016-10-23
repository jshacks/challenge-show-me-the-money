module Views.Watcher exposing (..)

import Html as H exposing (Html)
import Html.Attributes as A


type Msg
    = SetName String
    | SetPassword String
    | Submit


type alias Model =
    { name : String
    , password : String
    }


addDebtor =
    H.section [ A.class "add-debtor form-s" ]
        [ H.input [ A.type' "text", A.placeholder "Name" ] []
        , H.input [ A.type' "text", A.placeholder "Surname" ] []
        , H.input [ A.type' "date", A.placeholder "Birth Date" ] []
        , H.input [ A.type' "number", A.placeholder "CNP" ] []
        , H.input [ A.type' "number", A.placeholder "Total Debt" ] []
        , H.button [ A.class "submit" ] [ H.text "Add Debtor" ]
        ]


showDebtors =
    H.section [ A.class "debtors-table" ]
        [ H.h2 [] [ H.text "Debtors" ]
        , H.table []
            [ H.thead []
                [ H.tr []
                    [ H.th [] [ H.text "Name" ]
                    , H.th [] [ H.text "Surname" ]
                    , H.th [] [ H.text "Birth-date" ]
                    , H.th [] [ H.text "CNP" ]
                    , H.th [] [ H.text "Total Debt" ]
                    , H.th [] [ H.text "Debtor Details" ]
                    ]
                ]
            , H.tbody []
                [ H.tr []
                    [ H.td [] [ H.text "dummy Name" ]
                    , H.td [] [ H.text "dummy Surname" ]
                    , H.td [] [ H.text "dummy Birthdate" ]
                    , H.td [] [ H.text "1895245785" ]
                    , H.td [] [ H.text "10000 Lei" ]
                    , H.td [] [ H.button [] [ H.text "more / edit" ] ]
                    ]
                , H.tr []
                    [ H.td [] [ H.text "dummy Name" ]
                    , H.td [] [ H.text "dummy Surname" ]
                    , H.td [] [ H.text "dummy Birthdate" ]
                    , H.td [] [ H.text "1895245785" ]
                    , H.td [] [ H.text "10000 Lei" ]
                    , H.td [] [ H.button [] [ H.text "more / edit" ] ]
                    ]
                ]
            ]
        ]


debtorDetails =
    H.section
        [ A.class "debtor-view" ]
        [ H.h2 [] [ H.text "Debtor: Sile" ]
        , H.article [ A.class "debtor-info" ]
            [ H.h3 [] [ H.text "Personal Details" ]
            , H.p [] [ H.label [] [ H.text "First Name: " ], H.span [] [ H.text "<<fname>>" ] ]
            , H.p [] [ H.label [] [ H.text "Last Name: " ], H.span [] [ H.text "<<L name>>" ] ]
            , H.p [] [ H.label [] [ H.text "Birth Date: " ], H.span [] [ H.text "<<birth date>>" ] ]
            , H.p [] [ H.label [] [ H.text "CNP: " ], H.span [] [ H.text "<<cnp>>" ] ]
            , H.p [] [ H.label [] [ H.text "Total Debt: " ], H.span [] [ H.text "<<total debt>>" ] ]
            , H.button [] [ H.text "Edit Personal Details" ]
            ]
        , H.article [ A.class "add-debt form-s" ]
            [ H.h3 [] [ H.text "Add New Debt for Sile" ]
            , H.input [ A.type' "text", A.placeholder "Amount" ] []
            , H.textarea [ A.placeholder "Reason" ] []
            , H.button [ A.class "submit" ] [ H.text "Add Debt" ]
            ]
        ]


debtsList =
    H.section
        [ A.class "debts-list" ]
        [ H.h3 [] [ H.text "Incurred Debts" ]
        , H.article [ A.class "debts" ]
            [ H.p [] [ H.label [] [ H.text "Amount: " ], H.span [] [ H.text "514851 lei" ] ]
            , H.p [] [ H.label [] [ H.text "Reason " ], H.span [] [ H.text "Lorem ipsum dummy text" ] ]
            , H.button [] [ H.text "Edit Debt" ]
            ]
        , H.article [ A.class "debts" ]
            [ H.p [] [ H.label [] [ H.text "Amount: " ], H.span [] [ H.text "514851 lei" ] ]
            , H.p [] [ H.label [] [ H.text "Reason " ], H.span [] [ H.text "Lorem ipsum dummy text" ] ]
            , H.button [] [ H.text "Edit Debt" ]
            ]
        , H.article [ A.class "debts" ]
            [ H.p [] [ H.label [] [ H.text "Amount: " ], H.span [] [ H.text "514851 lei" ] ]
            , H.p [] [ H.label [] [ H.text "Reason " ], H.span [] [ H.text "Lorem ipsum dummy text" ] ]
            , H.button [] [ H.text "Edit Debt" ]
            ]
        , H.article [ A.class "debts" ]
            [ H.p [] [ H.label [] [ H.text "Amount: " ], H.span [] [ H.text "514851 lei" ] ]
            , H.p [] [ H.label [] [ H.text "Reason " ], H.span [] [ H.text "Lorem ipsum dummy text" ] ]
            , H.button [] [ H.text "Edit / Update" ]
            ]
        ]

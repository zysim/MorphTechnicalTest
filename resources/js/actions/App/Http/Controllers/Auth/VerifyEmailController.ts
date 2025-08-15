import { queryParams, type QueryParams } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Auth\VerifyEmailController::__invoke
* @see app/Http/Controllers/Auth/VerifyEmailController.php:14
* @route '/verify-email/{id}/{hash}'
*/
const VerifyEmailController = (args: { id: string | number, hash: string | number } | [id: string | number, hash: string | number ], options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: VerifyEmailController.url(args, options),
    method: 'get',
})

VerifyEmailController.definition = {
    methods: ['get','head'],
    url: '/verify-email/{id}/{hash}',
}

/**
* @see \App\Http\Controllers\Auth\VerifyEmailController::__invoke
* @see app/Http/Controllers/Auth/VerifyEmailController.php:14
* @route '/verify-email/{id}/{hash}'
*/
VerifyEmailController.url = (args: { id: string | number, hash: string | number } | [id: string | number, hash: string | number ], options?: { query?: QueryParams, mergeQuery?: QueryParams }) => {
    if (Array.isArray(args)) {
        args = {
            id: args[0],
            hash: args[1],
        }
    }

    const parsedArgs = {
        id: args.id,
        hash: args.hash,
    }

    return VerifyEmailController.definition.url
            .replace('{id}', parsedArgs.id.toString())
            .replace('{hash}', parsedArgs.hash.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Auth\VerifyEmailController::__invoke
* @see app/Http/Controllers/Auth/VerifyEmailController.php:14
* @route '/verify-email/{id}/{hash}'
*/
VerifyEmailController.get = (args: { id: string | number, hash: string | number } | [id: string | number, hash: string | number ], options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'get',
} => ({
    url: VerifyEmailController.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Auth\VerifyEmailController::__invoke
* @see app/Http/Controllers/Auth/VerifyEmailController.php:14
* @route '/verify-email/{id}/{hash}'
*/
VerifyEmailController.head = (args: { id: string | number, hash: string | number } | [id: string | number, hash: string | number ], options?: { query?: QueryParams, mergeQuery?: QueryParams }): {
    url: string,
    method: 'head',
} => ({
    url: VerifyEmailController.url(args, options),
    method: 'head',
})

export default VerifyEmailController
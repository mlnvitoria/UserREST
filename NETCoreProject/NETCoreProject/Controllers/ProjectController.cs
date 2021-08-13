using Microsoft.AspNetCore.Http;
using Microsoft.AspNetCore.Mvc;
using NETCoreProject.Attributes;
using NETCoreProject.Data.Interfaces;
using NETCoreProject.Models;
using System.Threading.Tasks;

namespace NETCoreProject.Controllers
{
    [Produces("application/json")]
    [Route("api/[controller]")]
    [ApiController]
    public abstract class ProjectController<TEntity, TRepository> : ControllerBase
        where TEntity : class, IEntity
        where TRepository : IRepository<TEntity>
    {
        protected readonly TRepository Repository;

        public ProjectController(TRepository repository)
        {
            Repository = repository;
        }

        [ApiToken]
        [ProducesResponseType(StatusCodes.Status200OK)]
        [ProducesResponseType(StatusCodes.Status404NotFound)]
        [HttpGet("{id}")]
        public async Task<ActionResult<TEntity>> GetById(int id)
        {
            var entity = await Repository.GetById(id);
            if (entity == null)
            {
                return NotFound();
            }

            return entity;
        }

        // POST: api/[controller]
        [ApiToken]
        [ProducesResponseType(StatusCodes.Status201Created)]
        [ProducesResponseType(StatusCodes.Status400BadRequest)]
        [HttpPost]
        public virtual async Task<ActionResult<TEntity>> Post(TEntity entity)
        {
            await Repository.Create(entity);

            return Created("", entity);
        }

        // PUT: api/[controller]/5
        [ApiToken]
        [ProducesResponseType(StatusCodes.Status204NoContent)]
        [ProducesResponseType(StatusCodes.Status400BadRequest)]
        [HttpPut("{id}")]
        public async Task<IActionResult> Put(int id, TEntity entity)
        {
            if (id != entity.Id)
            {
                return BadRequest();
            }
            TEntity result = await Repository.Update(entity);

            if (result == null)
            {
                return BadRequest();
            }

            return NoContent();
        }

        // DELETE: api/[controller]/5
        [ApiToken]
        [ProducesResponseType(StatusCodes.Status202Accepted)]
        [ProducesResponseType(StatusCodes.Status404NotFound)]
        [HttpDelete("{id}")]
        public async Task<ActionResult<TEntity>> Delete(int id)
        {
            var entity = await Repository.DeleteById(id);

            if (entity == null)
            {
                return NotFound();
            }

            return Accepted();
        }

    }
}
